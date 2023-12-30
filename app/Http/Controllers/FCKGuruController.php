<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Excel\Laporan;
use App\Models\Surat_report;
use App\Models\Surat;
use Illuminate\Http\Request;
use  App\Models\Jenis_surat;
use App\Models\Tmsurat_master;
use DataTables;
// use Doctrine\Inflector\Rules\Word;
// use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpWord\TemplateProcessor as Word;
use Illuminate\Support\Facades\DB;

use App\Helpers\Properti_app;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct(Request $request)
    {
        $this->request = $request;
        $this->view    = '.guru.';
        $this->route   = 'master.guru.';
    }

    public function index()
    {
        $title = 'Master Data Surat';
        $jenis_surat  = Jenis_surat::get();

        return view($this->view . 'index', compact('title', 'jenis_surat'));
    }


    protected function properti($d)
    {
        return [
            $d->jenis_surat_id = $this->request->jenis_surat_id,
            $d->site_id = $this->request->site_id,
            $d->site_name = $this->request->site_name,
            $d->nomor_pks = $this->request->nomor_pks,
            $d->alamat_site = $this->request->alamat_site,
            $d->pic_pemilik_lahan = $this->request->pic_pemilik_lahan,
            $d->nilai_sewa_tahun = $this->request->nilai_sewa_tahun,
            $d->periode_sewa_awal = $this->request->periode_sewa_awal,
            $d->periode_sewa_akhir = $this->request->periode_sewa_akhir,
            $d->nama_negosiator = $this->request->nama_negosiator,
            $d->email_negosiator = $this->request->email_negosiator,
            $d->nomor_hp_negosiator = $this->request->nomor_hp_negosiator,
            $d->revenue_3_bulan = $this->request->revenue_3_bulan,
            $d->revenue_2_bulan = $this->request->revenue_2_bulan,
            $d->revenue_1_bulan = $this->request->revenue_1_bulan,
            $d->harga_patokan = $this->request->harga_patokan
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Buat Data Surat';
        $jenis = Jenis_surat::get();
        return view($this->view . 'form_add', [
            'title' => $title,
            'jenis' => $jenis
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        try {
            $d = new Surat;
            $this->properti($d);
            $d->save();

            return response()->json([
                'status' => 1,
                'msg' => 'data berhasil dtambah'
            ]);
        } catch (Surat $t) {
            return response()->json([
                'status' => 1,
                'msg' =>  $t,
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Surat  $surat
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
    }

    public function api()
    {
        $from  = $this->request->from;
        $to = $this->request->to;

        $qr = Surat_report::select('*')->join('jenis_surat', 'surat_report.jenis_surat_id', '=', 'jenis_surat.jenis', 'left');
        if ($from != '' || $to != '') {
            $qr->whereBetween('surat_report.tanggal', [$from, $to]);
            $data = $qr->get();
        } else {
            $data = [];
        }
        return DataTables::of($data)
            ->addIndexColumn()
            ->rawColumns(['usercreate', 'proyek_name', 'action', 'id'])
            ->toJson();
    }

    public function xls_report()
    {
        // return Excel::download
        $request = $this->request;
        $namaFile = 'Report Surat.xlsx';
        return Excel::download(new Laporan($request), $namaFile);

        // $jenis = $this->request->jenis;
        // $from = date_format(date_create($this->request->dari),"Y-m-d");
        // $to = date_format(date_create($this->request->sampai),"Y-m-d");

        // if ($from == '' || $to == '') {
        //     return abort('Parameter tidak lengkap');
        // } else {
        //     $qr = Surat_report::select('*')->join('jenis_surat', 'surat_report.jenis_surat_id', '=', 'jenis_surat.jenis','left');

        //      if ($from != '' || $to != '') {
        //         $qr->whereBetween('surat_report.tanggal', [$from, $to]);
        //     }
        //     $data = $qr->get();
        //     $namaFile = 'Report Surat dari' . $from . 's/d' . $to.'.xls';
        //     header("Pragma: public");
        //     header("Expires: 0");
        //     header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        //     header("Content-Type: application/force-download");
        //     header("Content-Type: application/octet-stream");
        //     header("Content-Type: application/download");
        //     header("Content-Disposition: attachment;filename=" . $namaFile . "");
        //     header("Content-Transfer-Encoding: binary ");


        //     return view('laporan.surat_report', [
        //         'data' => $data,
        //         'dari' => $from,
        //         'sampai' => $to,
        //     ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Surat  $surat
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Master Data Surat';
        $d = Surat::find($id);

        return view($this->view . 'form_edit', [
            'id'                 => $d->id,
            'jenis_surat'        => Jenis_surat::get(),
            'jenis_surat_id'     => $d->jenis_surat_id,
            'site_id'            => $d->site_id,
            'site_name'          => $d->site_name,
            'nomor_pks'          => $d->nomor_pks,
            'alamat_site'        => $d->alamat_site,
            'pic_pemilik_lahan'  => $d->pic_pemilik_lahan,
            'nilai_sewa_tahun'   => $d->nilai_sewa_tahun,
            'periode_sewa_awal'  => $d->periode_sewa_awal,
            'periode_sewa_akhir' => $d->periode_sewa_akhir,
            'nama_negosiator'    => $d->nama_negosiator,
            'email_negosiator'   => $d->email_negosiator,
            'nomor_hp_negosiator' => $d->nomor_hp_negosiator,
            'revenue_3_bulan'    => $d->revenue_3_bulan,
            'revenue_2_bulan'    => $d->revenue_2_bulan,
            'revenue_1_bulan'    => $d->revenue_1_bulan,
            'harga_patokan'      => $d->harga_patokan,


        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Surat  $surat
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        // $this->request->validate([
        //     'jenis_surat_id' => 'required',
        //     'site_id' => 'required',
        //     'site_name' => 'required',
        //     'nomor_pks' => 'required',
        //     'alamat_site' => 'required',
        //     'pic_pemilik_lahan' => 'required',
        //     'nilai_sewa_tahun' => 'required',
        //     'periode_sewa_awal' => 'required',
        //     'periode_sewa_akhir' => 'required',
        //     'nama_negosiator' => 'required',
        //     'email_negosiator' => 'required',
        //     'nomor_hp_negosiator' => 'required',
        //     'revenue_3_bulan' => 'required',
        //     'revenue_2_bulan' => 'required',
        //     'revenue_1_bulan' => 'required',
        //     'harga_patokan' => 'required',

        // ]);
        try {
            $d = Surat::find($id);
            $jenis = $this->request->jenis_surat_id;


            $d->save();
            return response()->json([
                'status' => 1,
                'msg' => 'data berhasil dtambah'
            ]);
        } catch (\Tmlevel $t) {
            return response()->json([
                'status' => 1,
                'msg' =>  $t,
            ]);
        }
    }
    public function download($id, $jenis)
    {

        $ls_jenis = [
            'SIP',
            'SIT',
            'SPH',
            'SMR',
            'BAN'
        ];
        // dd($jenis . in_array($jenis, $ls_jenis));
        if (in_array($jenis, $ls_jenis)) {
            $filename =   $ls_jenis;
            $surat = Surat::join('jenis_surat', 'jenis_surat.id', '=', 'surat.jenis_surat_id')->where([
                'surat.id' => $id,
                'jenis_surat.jenis' => $jenis
            ])->first();
            // dd(strtolower($jenis));
            // dd(file_exists(public_path('file/surat/' . strtolower($jenis) . '.doc')));
            $suratword = new Word(storage_path('file/' . strtolower($jenis) . '.docx'));
            $suratword->setValues([
                'id' => $surat->id,
                'jenis_surat_id' => $surat->jenis_surat_id,
                'site_id' => $surat->site_id,
                'site_name' => $surat->site_name,
                'nomor_pks' => $surat->nomor_pks,
                'alamat_site' => $surat->alamat_site,
                'pic_pemilik_lahan' => $surat->pic_pemilik_lahan,
                'nilai_sewa_tahun' => $surat->nilai_sewa_tahun,
                'periode_sewa_awal' => $surat->periode_sewa_awal,
                'periode_sewa_akhir' => $surat->periode_sewa_akhir,
                'nama_negosiator' => $surat->nama_negosiator,
                'email_negosiator' => $surat->email_negosiator,
                'nomor_hp_negosiator' => $surat->nomor_hp_negosiator,
                'revenue_3_bulan' => $surat->revenue_3_bulan,
                'revenue_2_bulan' => $surat->revenue_2_bulan,
                'revenue_1_bulan' => $surat->revenue_1_bulan,
                'harga_patokan' => $surat->harga_patokan,
                'user_id' => $surat->user_id,
                'created_at' => $surat->created_at,
                'updated_at' => $surat->updated_at
            ]);
            $filename = $surat->jenis  . "_" . time() . ".docx";
            header('Content-type: application/octet-stream');
            header('Content-disposition: attachment; filename=' . $filename);
            $suratword->saveAs("php://output");
        }
    }

    public function report_surat()
    {
        $title       = 'Laporan Data Surat';
        $jenis_surat = Jenis_surat::get();
        $column = [
            // 'tmsurat_master.remark' => 'remark',
            'tmsurat_master.nomor_pks' => 'nomor_pks',
            'tmsurat_master.alamat_site' => 'alamat_site',
            'tmsurat_master.pic_pemilik_lahan' => 'pic_pemilik_lahan',
            'tmsurat_master.nilai_sewa_tahun' => 'nilai_sewa_tahun',
            'tmsurat_master.periode_sewa_awal' => 'periode_sewa_awal',
            'tmsurat_master.periode_sewa_akhir' => 'periode_sewa_akhir',
            'tmsurat_master.nama_negosiator' => 'nama_negosiator',
            'tmsurat_master.email_negosiator' => 'email_negosiator',
            'tmsurat_master.nomor_hp_negosiator' => 'nomor_hp_negosiator',
            'tmsurat_master.revenue_3_bulan' => 'revenue_3_bulan',
            'tmsurat_master.revenue_2_bulan' => 'revenue_2_bulan',
            'tmsurat_master.revenue_1_bulan' => 'revenue_1_bulan',
            'tmsurat_master.harga_patokan' => 'harga_patokan',
            // 'tmsurat_master.download' => 'download',
            // 'tmsurat_master.jenis' => 'jenis',
            // 'tmsurat_master.user_id' => 'user_id',
            // 'tmsurat_master.created_at' => 'created_at',
            // 'tmsurat_master.updated_at' => 'updated_at',
            // 'tmsurat_master.tgl_download' => 'tgl_download',
            'tmsurat_master.catatan' => 'catatan',
            'tmsurat_master.status_perpanjangan' => 'status_perpanjangan',
            // 'tmsurat_master.jenis_surat_id' => 'jenis_surat_id',
            'tmsurat_master.average' => 'average',
            'tmsurat_master.revenue_cat' => 'revenue_cat',
            'tmsurat_master.region' => 'region',
        ];
        return view($this->view . 'index', compact('title', 'jenis_surat', 'column'));
    }
    public function log()
    {
        $title = 'Log Access Surat';
        return view($this->view . 'log', compact('title'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Surat  $surat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Surat $surat)
    {
        try {
            if (is_array($this->request->id))
                $surat::whereIn('id', $this->request->id)->delete();
            else
                $surat::whereid($this->request->id)->delete();
            return response()->json([
                'status' => 1,
                'msg' => 'Data berhasil di hapus'
            ]);
        } catch (Surat $t) {
            return response()->json([
                'status' => 2,
                'msg' => $t
            ]);
        }
    }

    public function carijenis($param)
    {
        $ssparam = Properti_app::parameterColumn()[$param];
        return view($this->view . 'cari_jenis', [
            'paramscolum' => $ssparam,
            'jenis' => $param,
        ]);
    }
}
