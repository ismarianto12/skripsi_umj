<?php

namespace App\Http\Controllers;

use App\Helpers\Properti_app;
use Illuminate\Http\Request;
use App\Models\Tmbangunan;
use App\Models\Tmprogres_spk;
use DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\Tmproyek;
use App\Models\Tmrap;
use App\Models\Tmrspk;
use Mpdf\Mpdf  as PDF;


class TmreportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $request;
    protected $route;
    protected $view;
    function __construct(Request $request)
    {
        $this->request = $request;
        $this->view    = '.report.';
        $this->route   = 'master.report.';
    }
    function base64url_decode($data)
    {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }

    public function page()
    {

        // $
        $title    = 'Halaman Report';
        $jreports =  [
            [
                'id' => 'a',
                'name' => 'Laporan RAP per Bangunan dan per Proyek',
            ],
            [
                'id' => 'b',  'name' => 'Rekap SPK per Bangunan dan per Proyek'
            ],
            [
                'id' => 'c',
                'name' => 'Rekap Progress SPK per Bangunan per Proyek'
            ]
        ];
        $tmproyeks = Tmproyek::get();
        return view($this->view . 'index', compact('title', 'tmproyeks', 'jreports'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function action($url)
    {
        $report = Properti_app::parsing($url);
        if ($report['dari'] == '' and $report['sampai']  == '' and $report['name'] == '' and $report['tmproyek_id'] == '') {
            return abort('404', 'ada kesalahan dengna parameter yang di cari');
        }
        $tmproyeks_datas = Tmproyek::find($report['tmproyek_id']);
        $tmbangunan_datas = Tmbangunan::find($report['tmbangunan_id']);
        // get detail if select
        if ($report['dari'] != '' and $report['sampai'] != '' and $report['tmproyek_id'] == '' and $report['tmbangunan_id'] == '') {
            $ket = 'Report berdasarkan rentang waktu ' . Properti_app::tgl_indo($report['dari']) . 's/d' . Properti_app::tgl_indo($report['sampai']);
        } else if ($report['dari'] != ''  && $report['sampai'] != '' && $report['tmproyek_id'] != '' && $report['tmbangunan_id']  == '') {
            $ket = 'Report Berdasarkan bangunan yang di pilih' . $tmbangunan_datas['nama_bangunan'] . 'dan rentang waktu :' . Properti_app::tgl_indo($report['dari']) . 's/d' . Properti_app::tgl_indo($report['sampai']);;
        } else if ($report['dari'] != ''  && $report['sampai'] != '' && $report['tmproyek_id'] != '' && $report['tmbangunan_id'] != '') {
            $ket = 'Report berdasarkan proyek yang di pilih' . $tmproyeks_datas['nama_proyek'] . 'dan rentang waktu :' . Properti_app::tgl_indo($report['dari']) . 's/d' . Properti_app::tgl_indo($report['sampai']);
        } else if ($report['tmbangunan_id'] != '' and $report['tmproyek_id'] == '') {
            $ket = 'Report Berdasarkan Bangunan ' . $tmbangunan_datas['nama_bangunan'];
        } else if ($report['tmbangunan_id'] == '' and $report['tmproyek_id'] != '') {
            $ket = 'Report Berdasarkan Bangunan ' . $tmproyeks_datas['nama_proyek'];
        } else {
            $ket = 'Unknow report purpose';
        }
        // laporan', 'a) Laporan RAP per Bangunan dan per Proyek
        // 'laporan/perbulan', 'b) Rekap SPK per Bangunan dan per Proyek
        // 'grafik', 'c) Rekap Progress SPK per Bangunan per Proyek
        // 'grafik', 'd) Rekap Pembayaran SPK per Bangunan dan per Proyek per periode tertentu
        if ($this->request->type_data == 'xls') {
            $type = 'xls';
        } else if ($this->request->type_data == 'pdf') {
            $type = 'pdf';
        }
        $passed = [
            'dari' => $report['dari'],
            'sampai' => $report['sampai'],
            'name' => $report['name'],
            'ket' => $ket,
            'tmproyek_id' => $report['tmproyek_id'],
            'tmbangunan_id' => $report['tmbangunan_id'],
            'type_data' => $report['type_data']
        ];
        switch ($report['name']) {
            case 'a':
                // laporan', 'a) Laporan RAP per Bangunan dan per Proyek
                // dd('ss');
                return $this->report_rap($passed);
                break;
            case 'b':
                // 'laporan/perbulan', 'b) Rekap SPK per Bangunan dan per Proyek
                return $this->rpembayaran_spk($passed);
                break;
            case 'c':
                // 'grafik', 'c) Rekap Progress SPK per Bangunan per Proyek
                return $this->rprogress_spk($passed);
                # code...
                break;

            default:
                abort(404, 'jenis file yang di anda cari tidak ada .');
                break;
        }
    }

    public function report_rap($par)
    {
        $data = Tmrap::select(
            'users.name',
            'users.username',
            'users.email',
            'tmrap.pekerjaan',
            'tmrap.volume',
            'tmrap.satuan',
            'tmrap.harga_satuan',
            'tmrap.jumlah_harga',
            'tmproyek.kode',
            'tmproyek.nama_proyek',
            'tmproyek.tmbangunan_id',
            'tmproyek.tgl_mulai',
            'tmproyek.tgl_selesai',
            'tmrap.created_at',
            'tmrap.updated_at',
            'tmjenisrap.nama_rap',
            'tmjenisrap.kode_rap',
            'tmbangunan.nama_bangunan',
            'tmbangunan.kode'
        )
            ->join('tmproyek', 'tmrap.tmproyek_id', '=', 'tmproyek.id')
            ->join('tmjenisrap', 'tmrap.tmjenisrap_id', '=', 'tmjenisrap.id')
            ->join('users', 'tmrap.user_id', '=', 'users.id')
            ->join('tmbangunan', 'tmproyek.id', '=', 'tmbangunan.tmproyek_id');

        if ($par['dari'] != '' and $par['sampai'] != '' and $par['tmproyek_id'] == '' and $par['tmbangunan_id'] == '') {
            $r = $data->whereBetween(\DB::raw('tmrap.created_at'), [$par['dari'], $par['sampai']])->GroupBy('tmrap.tmbangunan_id');
        } else if ($par['dari'] != ''  && $par['sampai'] != '' && $par['tmproyek_id'] != '' && $par['tmbangunan_id']  == '') {
            $r = $data->whereBetween(\DB::raw('tmrap.created_at'), [$par['dari'], $par['sampai']])->GroupBy('tmrap.tmbangunan_id')
                ->where('tmproyek.id', $par['tmproyek_id'])->GroupBy('tmrap.tmbangunan_id');
        } else if ($par['dari'] != ''  && $par['sampai'] != '' && $par['tmproyek_id'] != '' && $par['tmbangunan_id'] != '') {
            $r = $data->whereBetween(\DB::raw('tmrap.created_at'), [$par['dari'], $par['sampai']])->where([
                'tmproyek.id' => $par['tmproyek_id'],
                'tmbangunan.id' => $par['tmbangunan_id']
            ])->GroupBy('tmrap.tmbangunan_id');
        } else if ($par['tmbangunan_id'] != '' and $par['tmproyek_id'] == '') {
            $r = $data->where('tmproyek.id', $par['tmproyek_id']);
        } else if ($par['tmbangunan_id'] == '' and $par['tmproyek_id'] != '') {
            $r = $data->where('tmbangunan.id', $par['tmbangunan_id']);
        } else {
            return abort('jenis paramter tidak di kenali', 404);
        }
        $fdata  = $r->get();
        $dari   = $par['dari'];
        $sampai = $par['sampai'];
        $ket    = $par['ket'];

        $render = view($this->view . 'report_rap', compact('fdata', 'dari', 'sampai', 'ket'));
        if ($par['type_data'] == 'xls') {

            $this->headerdownload('Pembayaran SPK Report Per Tanggal' . date('Y-m-d') . '.xls');
            return $render;
        }
        if ($par['type_data'] == 'pdf') {
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);
            $mpdf->SetTitle('Report Pembayaran RAP');
            $mpdf->WriteHTML($render);
            return $mpdf->Output();
        }
    }
    public function rpembayaran_spk($par)
    {

        // dd('this line detec right now');

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);
        $mpdf->SetTitle('Report Pembayaran SPK');

        $data = Tmrspk::select(
            'tmrspk.pekerjaan',
            'tmrspk.volume',
            'tmrspk.satuan',
            'tmrspk.tmrap_id',
            'tmrspk.tanggal',
            'tmrspk.no_spk',
            'tmrspk.spk_harga_satuan',
            'tmrspk.spk_jumlah_harga',
            'tmproyek.nama_proyek',
            'tmproyek.kode',
            'tmproyek.id',
            'trvendor.nama as nama_vendor',
            'tmbangunan.nama_bangunan',
            'tmbangunan.kode',
            'tmbangunan.ukuran',
            'tmjenisrap.kode_rap',
            'tmjenisrap.nama_rap'
        )
            ->join('tmrap', 'tmrap.id', '=', 'tmrspk.tmrap_id')
            ->join('tmproyek', 'tmrap.tmproyek_id', '=', 'tmproyek.id')
            ->join('tmbangunan', 'tmbangunan.id', '=', 'tmrap.tmbangunan_id')
            ->join('tmjenisrap', 'tmrap.tmjenisrap_id', '=', 'tmjenisrap.id')
            ->join('trvendor', 'trvendor.id', '=', 'tmrspk.trvendor_id');

        if ($par['dari'] != '' and $par['sampai'] != '' and $par['tmproyek_id'] == '' and $par['tmbangunan_id'] == '') {
            $r = $data->whereBetween(\DB::raw('tmrspk.tanggal'), [$par['dari'], $par['sampai']])->GroupBy('tmrap.tmbangunan_id');
        } else if ($par['dari'] != ''  && $par['sampai'] != '' && $par['tmproyek_id'] != '' && $par['tmbangunan_id']  == '') {
            $r = $data->whereBetween(\DB::raw('tmrspk.tanggal'), [$par['dari'], $par['sampai']])->GroupBy('tmrap.tmbangunan_id')
                ->where('tmrap.tmproyek_id', $par['tmproyek_id'])->GroupBy('tmrap.tmbangunan_id');
        } else if ($par['dari'] != ''  && $par['sampai'] != '' && $par['tmproyek_id'] != '' && $par['tmbangunan_id'] != '') {
            $r = $data->whereBetween(\DB::raw('tmrspk.tanggal'), [$par['dari'], $par['sampai']])->where([
                'tmrap.tmproyek_id' => $par['tmproyek_id'],
                'tmbangunan.id' => $par['tmbangunan_id']
            ])->GroupBy('tmrap.tmbangunan_id');
        } else if ($par['tmbangunan_id'] != '' and $par['tmproyek_id'] == '') {
            $r = $data->where('tmproyek.id', $par['tmproyek_id']);
        } else if ($par['tmbangunan_id'] == '' and $par['tmproyek_id'] != '') {
            $r = $data->where('tmbangunan.id', $par['tmbangunan_id']);
        } else {
            return abort('jenis paramter tidak di kenali', 404);
        }


        $fdata = $r->get();
        $dari = $par['dari'];
        $ket =  $par['ket'];
        $sampai = $par['sampai'];

        $render = view($this->view . 'rpembayaran_spk', compact('fdata', 'dari', 'sampai', 'ket'));
        if ($par['type_data'] == 'xls') {
            $this->headerdownload('Pembayaran SPK Report Per Tanggal' . date('Y-m-d') . '.xls');
            return $render;
        } else if ($par['type_data'] == 'pdf') {

            // dd($fdata);
            $mpdf->WriteHTML($render);
            return $mpdf->Output();
        }
    }
    private function rprogress_spk($par)
    {


        $data = Tmprogres_spk::select(
            'tmprogres_spk.tmrspk_id',
            'tmprogres_spk.periode_awal',
            'tmprogres_spk.periode_akhir',
            'tmprogres_spk.spk_progress_lalu',
            'tmprogres_spk.spk_progress_skg',
            'tmprogres_spk.spk_progress_tot',
            'tmprogres_spk.spk_harga_progres',
            'tmprogres_spk.spk_harga_sisa',

            'tmrspk.pekerjaan',
            'tmrspk.volume',
            'tmrspk.satuan',
            'tmrspk.tmrap_id',
            'tmrspk.tanggal',
            'tmrspk.no_spk',
            'tmrspk.spk_harga_satuan',
            'tmrspk.spk_jumlah_harga',
            'tmproyek.nama_proyek',
            'tmproyek.kode',
            'tmproyek.id',
            'trvendor.nama as nama_vendor',
            'tmbangunan.nama_bangunan',
            'tmbangunan.kode',
            'tmbangunan.ukuran',
            'tmjenisrap.kode_rap',
            'tmjenisrap.nama_rap'
        )
            ->join('tmrspk', 'tmprogres_spk.tmrspk_id', '=', 'tmrspk.id')
            ->join('tmrap', 'tmrap.id', '=', 'tmrspk.tmrap_id')
            ->join('tmproyek', 'tmrap.tmproyek_id', '=', 'tmproyek.id')
            ->join('tmbangunan', 'tmbangunan.id', '=', 'tmrap.tmbangunan_id')
            ->join('tmjenisrap', 'tmrap.tmjenisrap_id', '=', 'tmjenisrap.id')
            ->join('trvendor', 'trvendor.id', '=', 'tmrspk.trvendor_id');


        if ($par['dari'] != '' and $par['sampai'] != '' and $par['tmproyek_id'] == '' and $par['tmbangunan_id'] == '') {
            $r = $data->whereBetween(\DB::raw('tmprogres_spk.periode_awal'), [$par['dari'], $par['sampai']])->GroupBy('tmbangunan.id');
        } else if ($par['dari'] != ''  && $par['sampai'] != '' && $par['tmproyek_id'] != '' && $par['tmbangunan_id']  == '') {
            $r = $data->whereBetween(\DB::raw('tmprogres_spk.periode_awal'), [$par['dari'], $par['sampai']])->GroupBy('tmbangunan.id')
                ->where('tmrap.tmproyek_id', $par['tmproyek_id'])->GroupBy('tmbangunan.id');
        } else if ($par['dari'] != ''  && $par['sampai'] != '' && $par['tmproyek_id'] != '' && $par['tmbangunan_id'] != '') {
            $r = $data->whereBetween(\DB::raw('tmprogres_spk.periode_awal'), [$par['dari'], $par['sampai']])->where([
                'tmrap.tmproyek_id' => $par['tmproyek_id'],
                'tmbangunan.id' => $par['tmbangunan_id']
            ])->GroupBy('tmbangunan.id');
        } else if ($par['tmbangunan_id'] != '' and $par['tmproyek_id'] == '') {
            $r = $data->where('tmproyek.id', $par['tmproyek_id']);
        } else if ($par['tmbangunan_id'] == '' and $par['tmproyek_id'] != '') {
            $r = $data->where('tmbangunan.id', $par['tmbangunan_id']);
        } else {
            return abort('jenis paramter tidak di kenali', 404);
        }

        // dd($data->get());

        $fdata = $r->get();
        $dari = $par['dari'];
        $sampai = $par['sampai'];
        $ket =  $par['ket'];


        if ($par['type_data'] == 'xls') {
            $this->headerdownload('Data SPK.xls');
            return view($this->view . 'tmprogresspk', compact('fdata', 'dari', 'sampai', 'ket'));
        }
        if ($par['type_data'] == 'pdf') {
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);
            $mpdf->SetTitle('Report Progres Pembayaran SPK');

            $mpdf->WriteHTML(view($this->view . 'tmprogresspk', compact('fdata', 'dari', 'sampai', 'ket')));
            return $mpdf->Output();
        }
    }

    private function headerdownload($namaFile)
    {
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");
    }

    public function getbuild()
    {
        $id = $this->request->id; //that means of primary key of table tmbangungan
        // $sesion_proyek = Auth::user()->proyek_id;
        $datas = Tmbangunan::where('tmproyek_id', $id)->get();
        return response()->json($datas);
    }
}
