<?php

namespace App\Http\Controllers;

use App\Helpers\Properti_app;
use App\Http\Controllers\Excel\SuratExcel;
use App\Models\Jenis_surat;
use App\Models\Surat;
use App\Models\tmp_surat;
use App\Models\tmsurat_log;
use App\Models\Tmsurat_master;
use Carbon\Carbon;
use DataTables;
use DateTime;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpWord\TemplateProcessor as Word;

class Tmsurat_masterController extends Controller
{
    public function __construct(Request $request)
    {
        date_default_timezone_set("Asia/Jakarta");
        $this->request = $request;
        $this->view = '.tmsurat_master.';
        $this->route = 'master.tmsurat_master.';
    }

    public function index()
    {
        $title = 'Renewal Site';
        return view($this->view . 'index', compact('title'));
    }
    public function excel()
    {
        $namaFile = 'Report_surat.xlsx';
        return Excel::download(new SuratExcel($this->request), $namaFile);
    }

    protected function properti($d)
    {
        return [
            'id' => $d->id,
            'site_id' => $d->site_id,
            'site_name' => $d->site_name,
            'alamat_site' => $d->alamat_site,
            'nama_negosiator' => $d->nama_negosiator,
            'nomor_pks' => $d->nomor_pks,
            'pic_pemilik_lahan' => $d->pic_pemilik_lahan,
            'nilai_sewa_tahun' => $d->nilai_sewa_tahun,
            'periode_sewa_awal' => $d->periode_sewa_awal,
            'periode_sewa_akhir' => $d->periode_sewa_akhir,
            'email_negosiator' => $d->email_negosiator,
            'nomor_hp_negosiator' => $d->nomor_hp_negosiator,
            'user_id' => $d->user_id,
            'created_at' => $d->created_at,
            'updated_at' => $d->updated_at,
        ];
    }

    public function delete_tmp()
    {
        $from = Carbon::now()->subDays(1);
        $to = Carbon::now()->subDays(2);

        $a = tmp_surat::whereBetween('created_at', [
            $to->format('Y-m-d'),
            $from->format('Y-m-d'),
        ])->delete();
        // dd($a);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $title = 'Buat Data Surat';
        $jenis = $this->request->jenis;
        $sekarang = Carbon::now()->format('Y-m-d');
        $site_id = $this->request->site_id;

        $datanya = Tmsurat_master::where('site_id', $site_id)->firstOrfail();
        $tgl_download = isset($datanya->tgl_download) ? $datanya->tgl_download : "";
        $this->delete_tmp();
        $sql = tmp_surat::where('site_id', $site_id)
            ->whereRaw(\DB::raw('FIND_IN_SET("' . $jenis . '",jenis_surat_id)'))
            ->whereRaw(\DB::raw('date(created_at)', date('Y-m-d')))
            ->orderBy('site_id', 'desc')->limit(1);
        $k = 1;
        $qletter_no = tmp_surat::where('site_id', $site_id)->first();

        $no_surat = isset($qletter_no[trim('nomor_surat_' . strtolower($jenis))]) ? $qletter_no[trim('nomor_surat_' . strtolower($jenis))] : '';
        $nomor_surat = isset($qletter_no['nomor_surat']) ? $qletter_no['nomor_surat'] : '';
        $tglsurat = isset($qletter_no['created_at']) ? date('Y-m-d') : date('Y-m-d');
        if ($jenis == 'SMR') {
            $data = $sql->first();
            if ($sql->count() > 0) {
                return view($this->view . 'form_add', [
                    'tmp_id' => isset($data->id) ? $data->id : '',
                    'nomor_surat_landlord' => isset($data['nomor_surat_landlord']) ? $data['nomor_surat_landlord'] : '',
                    'periode_sewa_baru_d' => isset($data['periode_sewa_baru_d']) ? $data['periode_sewa_baru_d'] : '',
                    'periode_sewa_baru_sd' => isset($data['periode_sewa_baru_sd']) ? $data['periode_sewa_baru_sd'] : '',

                    'tgl_surat' => $tglsurat,
                    'no_surat' => isset($no_surat) ? $no_surat : $nomor_surat,
                    'penawaran_th_1' => isset($data->penawaran_th_1) ? $data->penawaran_th_1 : '',
                    'penawaran_th_2' => isset($data->penawaran_th_2) ? $data->penawaran_th_2 : '',
                    'penawaran_th_3' => isset($data->penawaran_th_3) ? $data->penawaran_th_3 : '',
                    'penawaran_th_4' => isset($data->penawaran_th_4) ? $data->penawaran_th_4 : '',
                    'pemilik_1' => isset($data->pemilik_1) ? $data->pemilik_1 : '',
                    'pemilik_2' => isset($data->pemilik_2) ? $data->pemilik_2 : '',
                    'pemilik_3' => isset($data->pemilik_3) ? $data->pemilik_3 : '',
                    'pemilik_4' => isset($data->pemilik_4) ? $data->pemilik_4 : '',
                    'harga_sewa_baru' => isset($data->harga_sewa_baru) ? $data->harga_sewa_baru : '',
                    'title' => $title,
                    'tgl_download' => $tgl_download,
                    'skrg' => $sekarang,
                    'jenis' => $jenis,
                    'jdownload' => $this->request->jumlah,
                    'datanya' => $datanya,
                    'site_id' => $site_id,
                    'download' => isset($datanya->download) ? $datanya->download : '',
                    'updated_at' => isset($datanya->updated_at) ? $datanya->updated_at : '',
                    'total_harga_baru' => isset($data->total_harga_baru) ? $data->total_harga_baru : '',
                    'durasi_sewa' => isset($data->durasi_sewa) ? $data->durasi_sewa : '',
                ]);
            } else {
                return view($this->view . 'form_add', [
                    'no_surat' => isset($no_surat) ? $no_surat : $nomor_surat,
                    'tmp_id' => '',
                    'nomor_surat_landlord' => isset($data['nomor_surat_landlord']) ? $data['nomor_surat_landlord'] : '',
                    'periode_sewa_baru_d' => isset($data['periode_sewa_baru_d']) ? $data['periode_sewa_baru_d'] : '',
                    'periode_sewa_baru_sd' => isset($data['periode_sewa_baru_sd']) ? $data['periode_sewa_baru_sd'] : '',

                    'penawaran_th_1' => '',
                    'no_surat' => '',
                    'penawaran_th_2' => '',
                    'penawaran_th_3' => '',
                    'penawaran_th_4' => '',
                    'pemilik_1' => '',
                    'pemilik_2' => '',
                    'pemilik_3' => '',
                    'pemilik_4' => '',
                    'harga_sewa_baru' => '',
                    'title' => $title,
                    'tgl_download' => '',
                    'skrg' => '',
                    'jenis' => $jenis,
                    'tgl_surat' => $tglsurat,
                    'jdownload' => '',
                    'datanya' => $datanya,
                    'site_id' => $site_id,
                    'download' => '',
                    'updated_at' => '',
                ]);
            }
        } else if ($jenis == 'BAN') {

            $ban = tmp_surat::where('site_id', $site_id)
                ->whereRaw(\DB::raw('FIND_IN_SET("SMR",jenis_surat_id)'))
                ->whereRaw(\DB::raw('date(created_at)', date('Y-m-d')))
                ->orderBy('site_id', 'desc')->limit(1);
            $k = 1;
            if ($ban->count() > 0) {
                return view($this->view . 'form_add', [
                    'tmp_id' => '',
                    'no_surat' => isset($no_surat) ? $no_surat : $nomor_surat,
                    'tgl_surat' => $tglsurat,
                    'penawaran_th_1' => $ban->first()->penawaran_th_1,
                    'penawaran_th_2' => $ban->first()->penawaran_th_2,
                    'penawaran_th_3' => $ban->first()->penawaran_th_3,
                    'penawaran_th_4' => $ban->first()->penawaran_th_4,
                    'pemilik_1' => $ban->first()->pemilik_1,
                    'pemilik_2' => $ban->first()->pemilik_2,
                    'pemilik_3' => $ban->first()->pemilik_3,
                    'pemilik_4' => $ban->first()->pemilik_4,
                    'harga_sewa_baru' => $ban->first()->harga_sewa_baru,
                    'title' => '',
                    'tgl_download' => '',
                    'skrg' => '',
                    'pengelola' => isset($ban->first()->pengelola) ? $ban->first()->pengelola : '',
                    'nama_pic' => isset($ban->first()->nama_pic) ? $ban->first()->nama_pic : '',
                    'alamat_pic' => isset($ban->first()->alamat_pic) ? $ban->first()->alamat_pic : '',
                    'jabatan_pic' => isset($ban->first()->jabatan_pic) ? $ban->first()->jabatan_pic : '',
                    'nomor_telepon_pic' => isset($ban->first()->nomor_telepon_pic) ? $ban->first()->nomor_telepon_pic : '',

                    'jdownload' => '',
                    'datanya' => '',
                    'site_id' => '',
                    'download' => '',
                    'updated_at' => '',
                    'title' => $title,
                    'tgl_download' => $tgl_download,
                    'skrg' => $sekarang,
                    'jenis' => $jenis,
                    'jdownload' => $this->request->jumlah,
                    'datanya' => $datanya,
                    'site_id' => $site_id,
                    'download' => isset($datanya->download) ? $datanya->download : '',
                    'updated_at' => isset($datanya->updated_at) ? $datanya->updated_at : '',
                ]);
            } else {
                return '<div class="alert alert-danger">Silahkan tambahkan data SMR terlebih dahulu</div>';
            }
        } else if ($jenis == 'BAK') {
            $csql = tmp_surat::where('site_id', $site_id)
                ->whereRaw(\DB::raw('FIND_IN_SET("BAN",jenis_surat_id)'))
                ->whereRaw(\DB::raw('date(created_at)', date('Y-m-d')))
                ->orderBy('site_id', 'desc')->limit(1);
            if ($csql->count() > 0) {
                $data = $csql->first();
                return view($this->view . 'form_add', [
                    'penawaran_harga_sewa' => isset($data->penawaran_harga_sewa) ? $data->penawaran_harga_sewa : '',
                    'no_surat' => isset($no_surat) ? $no_surat : $nomor_surat,
                    'harga_sewa_baru' => isset($data->harga_sewa_baru) ? $data->harga_sewa_baru : '',
                    'nama_pic' => isset($data->nama_pic) ? $data->nama_pic : '',
                    'jabatan_pic' => isset($data->jabatan_pic) ? $data->jabatan_pic : '',
                    'pengelola' => isset($data->pengelola) ? $data->pengelola : '',
                    'no_telp_pic' => isset($data->nomor_telepon_pic) ? $data->nomor_telepon_pic : '',
                    'alamat_pic' => isset($data->alamat_pic) ? $data->alamat_pic : '',
                    'tmp_id' => isset($data->id) ? $data->id : '',
                    'periode_awal' => isset($data->periode_awal) ? $data->periode_awal : '',
                    'periode_akhir' => isset($data->periode_akhir) ? $data->periode_akhir : '',
                    'lokasi_tempat_sewa' => isset($data->lokasi_tempat_sewa) ? $data->lokasi_tempat_sewa : '',
                    'luas_tempat_sewa' => isset($data->luas_tempat_sewa) ? $data->luas_tempat_sewa : '',
                    'nomor_rekening' => isset($data->nomor_rekening) ? $data->nomor_rekening : '',
                    'pemilik_rekening' => isset($data->pemilik_rekening) ? $data->pemilik_rekening : '',
                    'bank' => isset($data->bank) ? $data->bank : '',

                    'cabang' => isset($data->cabang) ? $data->cabang : '',
                    'npwp' => isset($data->npwp) ? $data->npwp : '',
                    'nomor_npwp' => isset($data->nomor_npwp) ? $data->nomor_npwp : '',
                    'pemilik_npwp' => isset($data->pemilik_npwp) ? $data->pemilik_npwp : '',
                    'nomor_shm_ajb_hgb' => isset($data->nomor_shm_ajb_hgb) ? $data->nomor_shm_ajb_hgb : '',
                    'nomor_imb' => isset($data->nomor_imb) ? $data->nomor_imb : '',
                    'nomor_sppt_pbb' => isset($data->nomor_sppt_pbb) ? $data->nomor_sppt_pbb : '',

                    'title' => $title,
                    'tgl_download' => $tgl_download,
                    'skrg' => $sekarang,
                    'jenis' => $jenis,
                    'jdownload' => $this->request->jumlah,
                    'datanya' => $datanya,
                    'site_id' => $site_id,
                    'download' => isset($datanya->download) ? $datanya->download : '',
                    'tgl_surat' => $tglsurat,
                ]);
            } else {
                return '<div class="alert alert-danger">Silahkan tambahkan data surat BAN terlebih dahulu</div>';
            }
        } else {
            return view($this->view . 'form_add', [
                'penawaran_harga_sewa' => isset($datanya->penawaran_harga_sewa) ? $datanya->penawaran_harga_sewa : '',
                'periode_sewa_penawaran_awal' => isset($datanya->periode_sewa_penawaran_awal) ? $datanya->periode_sewa_penawaran_awal : '',
                'periode_sewa_penawaran_akhir' => isset($datanya->periode_sewa_penawaran_akhir) ? $datanya->periode_sewa_penawaran_akhir : '',
                'pic_landlord' => isset($datanya->pic_landlord) ? $datanya->pic_landlord : '',
                'jabatan_landlord' => isset($datanya->jabatan_landlord) ? $datanya->jabatan_landlord : '',

                // smr
                'nomor_surat_landlord' => isset($qletter_no['nomor_surat_landlord']) ? $qletter_no['nomor_surat_landlord'] : '',
                'tanggal_surat_landlord' => isset($qletter_no['tanggal_surat_landlord']) ? $qletter_no['tanggal_surat_landlord'] : '',
                'title' => $title,
                'no_surat' => isset($no_surat) ? $no_surat : $nomor_surat,
                'tgl_download' => $tgl_download,
                'skrg' => $sekarang,
                'jenis' => $jenis,
                'jdownload' => $this->request->jumlah,
                'datanya' => $datanya,
                'tgl_surat' => $tglsurat,
                'tanggal_surat' => $tglsurat,
                'site_id' => $site_id,
                'download' => isset($datanya->download) ? $datanya->download : '',
                'updated_at' => isset($datanya->updated_at) ? $datanya->updated_at : '',
            ]);
        }
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

        } catch (Surat $t) {
            return response()->json([
                'status' => 1,
                'msg' => $t,
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Surat  $surat
     * @return \Illuminate\Http\Response
     */
    public function show(Surat $surat)
    {
    }

    public function api()
    {
        $tahun = $this->request->contract;
        $data = Tmsurat_master::select(
            'tmsurat_master.id',
            'tmsurat_master.remark',
            'tmsurat_master.site_id',
            'tmsurat_master.site_name',
            'tmsurat_master.nomor_pks',
            'tmsurat_master.alamat_site',
            'tmsurat_master.pic_pemilik_lahan',
            'tmsurat_master.nilai_sewa_tahun',
            'tmsurat_master.periode_sewa_awal',
            'tmsurat_master.periode_sewa_akhir',
            'tmsurat_master.nama_negosiator',
            'tmsurat_master.email_negosiator',
            'tmsurat_master.nomor_hp_negosiator',
            'tmsurat_master.revenue_3_bulan',
            'tmsurat_master.revenue_2_bulan',
            'tmsurat_master.revenue_1_bulan',
            'tmsurat_master.harga_patokan',
            'tmsurat_master.status_perpanjangan',
            'tmsurat_master.catatan'
        );
        if ($this->request->contract) {
            $data->where('tmsurat_master.tmtahun_id', $tahun);
        }
        $sql = $data->get();

        return DataTables::of($sql)
            ->editColumn('id', function ($p) {
                return "<input type='checkbox' name='cbox[]' value='" . $p->id . "' />";
            })
            ->editColumn('action', function ($p) {
                $html = '
                <select name="jenis_surat" id="jenis_suratnya" class="form-control form-sm">
                <option value="">Pilih </option>'; 
                $data = Jenis_surat::get();  
                foreach ($data as $datas) {
                    $ck = tmp_surat::where('site_id', $p->site_id)
                        ->whereRaw(\DB::raw('FIND_IN_SET("' . $datas->jenis . '",jenis_surat_id)'))
                        ->whereRaw(\DB::raw('date(created_at)', date('Y-m-d')))
                        ->orderBy('site_id', 'desc')->count();

                    $ls = ($ck > 0) ? ' <small>' . $ck . 'x</small>' : '';
                    $selected = $datas->id == $p->jenis_surat ? 'selected' : '';
                    $html .= '<option value="' . $datas->jenis . '" ' . $selected . ' site_id="' . $p->site_id . '">' . $datas->ket . $ls . '</option>';
                }
                $html .= '</select>';
                return $html;
            }, true)
            ->editColumn('status_perpanjangan', function ($p) {
                $variable = Properti_app::status_perpanjang();
                $html = '
                <select name="status_perpanjagan" id="status_perpanjangan" class="form-control form-sm">
                <option value="">Negosiasi</option>';
                foreach ($variable as $key => $value) {
                    $selected = $p->status_perpanjangan == $key ? 'selected' : '';
                    $html .= '<option value="' . trim($key) . '" ' . $selected . ' site_id="' . $p->site_id . '">' . $value . '</opt
                    ion>';
                }

                $html .= '</select>';
                return $html;
            }, true)
            ->editColumn('catatan', function ($p) {
                $html = '
                <p><textarea name="catatan" id="catatan">' . $p->catatan . '</textarea> <button id_site="' . $p->site_id . '" class="simpan_xx btn btn-primary btn-sm"><i class="fa fa-save"></i></button><button class="reset_xxs btn btn-warning btn-sm"><i class="fa fa-share"></i></button></p>';
                return $html;
            }, true)
            ->addIndexColumn()
            ->rawColumns(['action', 'id', 'status_perpanjangan', 'catatan'])
            ->toJson();
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
        $d = Tmsurat_master::find($id);

        return view($this->view . 'form_edit', [
            'id' => $d->id,
            'site_id' => $d->site_id,
            'site_name' => $d->site_name,
            'alamat_site' => $d->alamat_site,
            'nama_negosiator' => $d->nama_negosiator,
            'nomor_pks' => $d->nomor_pks,
            'pic_pemilik_lahan' => $d->pic_pemilik_lahan,
            'nilai_sewa_tahun' => $d->nilai_sewa_tahun,
            'periode_sewa_awal' => $d->periode_sewa_awal,
            'periode_sewa_akhir' => $d->periode_sewa_akhir,
            'email_negosiator' => $d->email_negosiator,
            'nomor_hp_negosiator' => $d->nomor_hp_negosiator,
            'user_id' => $d->user_id,
            'created_at' => $d->created_at,
            'updated_at' => $d->updated_at,
            'title' => $title,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Surat  $surat
     * @return \Illuminate\Http\Response
     */

    private function cal_percentage($num_amount, $num_total)
    {
        $count1 = $num_amount / $num_total;
        $count2 = $count1 * 100;
        $count = number_format($count2, 0);
        return $count;
    }

    public function update($id)
    {
        try {
            $d = Tmsurat_master::find($id);
            $d->site_id = $this->request->site_id;
            $d->site_name = $this->request->site_name;
            $d->alamat_site = $this->request->alamat_site;
            $d->nama_negosiator = $this->request->nama_negosiator;
            $d->nomor_pks = $this->request->nomor_pks;
            $d->pic_pemilik_lahan = $this->request->pic_pemilik_lahan;
            $d->nilai_sewa_tahun = $this->request->nilai_sewa_tahun;
            $d->periode_sewa_awal = $this->request->periode_sewa_awal;
            $d->periode_sewa_akhir = $this->request->periode_sewa_akhir;
            $d->email_negosiator = $this->request->email_negosiator;
            $d->nomor_hp_negosiator = $this->request->nomor_hp_negosiator;

            $d->save();
            return response()->json([
                'status' => 1,
                'msg' => 'data berhasil dtambah',
            ]);
        } catch (\Tmlevel$t) {
            return response()->json([
                'status' => 1,
                'msg' => $t,
            ]);
        }
    }

    public function xmlEntities($str)
    {
        $xml = array('&#34;', '&#38;', '&#38;', '&#60;', '&#62;', '&#160;', '&#161;', '&#162;', '&#163;', '&#164;', '&#165;', '&#166;', '&#167;', '&#168;', '&#169;', '&#170;', '&#171;', '&#172;', '&#173;', '&#174;', '&#175;', '&#176;', '&#177;', '&#178;', '&#179;', '&#180;', '&#181;', '&#182;', '&#183;', '&#184;', '&#185;', '&#186;', '&#187;', '&#188;', '&#189;', '&#190;', '&#191;', '&#192;', '&#193;', '&#194;', '&#195;', '&#196;', '&#197;', '&#198;', '&#199;', '&#200;', '&#201;', '&#202;', '&#203;', '&#204;', '&#205;', '&#206;', '&#207;', '&#208;', '&#209;', '&#210;', '&#211;', '&#212;', '&#213;', '&#214;', '&#215;', '&#216;', '&#217;', '&#218;', '&#219;', '&#220;', '&#221;', '&#222;', '&#223;', '&#224;', '&#225;', '&#226;', '&#227;', '&#228;', '&#229;', '&#230;', '&#231;', '&#232;', '&#233;', '&#234;', '&#235;', '&#236;', '&#237;', '&#238;', '&#239;', '&#240;', '&#241;', '&#242;', '&#243;', '&#244;', '&#245;', '&#246;', '&#247;', '&#248;', '&#249;', '&#250;', '&#251;', '&#252;', '&#253;', '&#254;', '&#255;');
        $html = array('&quot;', '&amp;', '&amp;', '&lt;', '&gt;', '&nbsp;', '&iexcl;', '&cent;', '&pound;', '&curren;', '&yen;', '&brvbar;', '&sect;', '&uml;', '&copy;', '&ordf;', '&laquo;', '&not;', '&shy;', '&reg;', '&macr;', '&deg;', '&plusmn;', '&sup2;', '&sup3;', '&acute;', '&micro;', '&para;', '&middot;', '&cedil;', '&sup1;', '&ordm;', '&raquo;', '&frac14;', '&frac12;', '&frac34;', '&iquest;', '&Agrave;', '&Aacute;', '&Acirc;', '&Atilde;', '&Auml;', '&Aring;', '&AElig;', '&Ccedil;', '&Egrave;', '&Eacute;', '&Ecirc;', '&Euml;', '&Igrave;', '&Iacute;', '&Icirc;', '&Iuml;', '&ETH;', '&Ntilde;', '&Ograve;', '&Oacute;', '&Ocirc;', '&Otilde;', '&Ouml;', '&times;', '&Oslash;', '&Ugrave;', '&Uacute;', '&Ucirc;', '&Uuml;', '&Yacute;', '&THORN;', '&szlig;', '&agrave;', '&aacute;', '&acirc;', '&atilde;', '&auml;', '&aring;', '&aelig;', '&ccedil;', '&egrave;', '&eacute;', '&ecirc;', '&euml;', '&igrave;', '&iacute;', '&icirc;', '&iuml;', '&eth;', '&ntilde;', '&ograve;', '&oacute;', '&ocirc;', '&otilde;', '&ouml;', '&divide;', '&oslash;', '&ugrave;', '&uacute;', '&ucirc;', '&uuml;', '&yacute;', '&thorn;', '&yuml;');
        $str = str_replace($html, $xml, $str);
        $str = str_ireplace($html, $xml, $str);
        return $str;
    }
    public function download()
    {

        setlocale(LC_TIME, 'IND'); // or setlocale(LC_TIME, 'id_ID');

        $ls_jenis = [
            'BAK',
            'SIP',
            'SIT',
            'SPH',
            'SMR',
            'BAN',
        ];
        $site_id = $this->request->site_id;
        $jenis = $this->request->jenis;
        if (in_array($jenis, $ls_jenis)) {
            $filename = $ls_jenis;
            $surat = Tmsurat_master::where([
                'tmsurat_master.site_id' => $site_id,
            ])->first();

            $revenue_3_bulan = isset($surat->revenue_3_bulan) ? $surat->revenue_3_bulan : 0;
            $revenue_2_bulan = isset($surat->revenue_2_bulan) ? $surat->revenue_2_bulan : 0;
            $revenue_1_bulan = isset($surat->revenue_1_bulan) ? $surat->revenue_1_bulan : 0;

            $rata_revenue_perbulan = (((int) str_replace(',', '', $revenue_3_bulan) + (int) str_replace(',', '', $revenue_2_bulan) + (int) str_replace(',', '', $revenue_1_bulan)) / 3);
            $rata_reveenue_pertahun = ($rata_revenue_perbulan * 12);
            $kenaikan_harga_sewa = (((int) str_replace('.', '', $this->request->harga_sewa_baru) - (int) str_replace(
                ',',
                '',
                $surat->nilai_sewa_tahun
            )) / (int) str_replace(',', '', $surat->nilai_sewa_tahun)) * 100;
            // dd($kenaikan_harga_sewa);
            $persentase_harga_sewa = ((int) str_replace('.', '', $this->request->harga_sewa_baru) / (int) trim($rata_reveenue_pertahun)) * 100;
            // dd($persentase_harga_sewa);
            $number_rounded = round($persentase_harga_sewa, PHP_ROUND_HALF_UP);
            $no_surat = $this->request->no_surat;

            if ($this->request->periode_sewa_baru_sd < $this->request->periode_sewa_baru_d) {
                $pesan = 'Periode sewa baru awal tidak boleh lebih kecil dari periode sewa akhir';
                return response()->json(['errors' => ['psan' => [$pesan]]], 422);
                exit();
            }
            if (in_array($jenis, [
                'BAN',
                'SMR',
            ])) {
                $tgl_srt = '';
            } else {
                if ($jenis == 'SMR') {
                    $tgl_srt = '';
                } else if ($jenis == 'SPH') {
                    $tgl_srt = trim(Properti_app::tgl_indo($this->request->tanggal_surat_landlord));
                } else {
                    if ($this->request->tgl_surat != '' || $this->request->tgl_surat != null) {
                        $tgl_srt = trim(Properti_app::tgl_indo($this->request->tgl_surat));
                    } else {
                        $tgl_srt = trim(Properti_app::tgl_indo(date('Y-m-d')));
                    }
                }
            }

            $awal_periode_sewa = date_create($this->request->periode_sewa_baru_sd);
            $fawal_periode_sewa = date_add($awal_periode_sewa, date_interval_create_from_date_string('2 days'));
            $tfawal_periode_sewa = date_format($fawal_periode_sewa, 'Y-m-d');

            $a = new DateTime($this->request->periode_sewa_baru_d);
            $b = new DateTime($tfawal_periode_sewa);
            $pg = date_diff($b, $a);
            $durasi_sw = $pg->format('%y');
            if ($durasi_sw > 0) {
                $durasi_sw = $durasi_sw . ' Tahun';
                $ldurasi_sw = $durasi_sw;
            } else {
                $durasi_sw = $this->request->durasi_sewa;
                $ldurasi_sw = 0;
            }
            if ($ldurasi_sw > 0) {
                $jjk = ((int) str_replace('.', '', $this->request->harga_sewa_baru) * (int) $ldurasi_sw);
            } else {
                $jjk = (int) str_replace('.', '', $this->request->harga_sewa_baru);
            }
            $psr = number_format($jjk, 0, 0, '.');
            if ((int) str_replace('.', '', $this->request->harga_sewa_baru) <= (int) str_replace(',', '', $surat->harga_patokan)) {
                $ket = "[x] Dibawah Harga Patokan [-] Diatas Harga Patokan";
                $ket_temp = "Dibawah Harga Patokan";
            } else if ((int) str_replace('.', '', $this->request->harga_sewa_baru) >= (int) str_replace(',', '', $surat->harga_patokan)) {
                $ket = "[x] Diatas Harga Patokan [-] Dibawah Harga Patokan";
                $ket_temp = "Diatas Harga Patokan";
            }
            $sql = tmp_surat::where('site_id', $site_id)->orderBy('id', 'desc')->limit(1)->first();

            $bak_h_sewa_baru = isset($sql->harga_sewa_baru) ? (int) str_replace('.', '', $sql->harga_sewa_baru) : 0;
            $bak_durasi_sewa = isset($sql->durasi_sewa) ? (int) str_replace(['.', ',', 'Tahun', 'tahun'], '', $sql->durasi_sewa) : 0;
            if ($jenis == 'BAK') {
                $bak_total_harga_net = ((((int) str_replace('.', '', $bak_h_sewa_baru) * 9) / 10) * $bak_durasi_sewa);
            } else {
                $bak_total_harga_net = ((((int) str_replace('.', '', $bak_h_sewa_baru) * 9) / 10) * $bak_durasi_sewa);
            }
            $explode_tgl = $this->request->tgl_surat;
            $kexplode_tgl_date = date_create($explode_tgl);
            $sexplode_tgl_date = date_format($kexplode_tgl_date, 'D');
            $fexplode_tgl_date = date_format($kexplode_tgl_date, 'M');

            $bka = date_create($this->request->periode_akhir);
            $bkb = date_create($this->request->periode_awal);
            $bkc = date_format($bka, 'Y-m-d');
            $bkd = date_format($bkb, 'Y-m-d');
            $bkpg = date_diff($bka, $bkb);
            $bkdurasi_sw = $bkpg->format('%Y%');

            $column_partial = [
                'SIP' => ['nomor_surat_sip' => "no_surat", 'tanggal_surat' => "tgl_surat"], // Jenis surat SIP
                'SIT' => ['nomor_surat_sit' => "no_surat", 'tanggal_surat' => "tgl_surat"], // Jenis surat SIT
                'SPH' => [
                    "nomor_surat_sph" => 'no_surat', "tanggal_surat" => 'tanggal_surat', "nomor_surat_landlord" => 'nomor_surat_landlord',
                    "perihal_surat_landlord" => 'perihal_surat_landlord', "pic_landlord" => 'pic_landlord', "jabatan_landlord" => 'jabatan_landlord',
                    "penawaran_harga_sewa" => 'penawaran_harga_sewa',
                    'periode_sewa_penawaran_awal' => 'periode_sewa_penawaran_awal', 'periode_sewa_penawaran_akhir' => 'periode_sewa_penawaran_akhir',
                ], //dari jenis SPH
                'SMR' => [
                    "harga_sewa_baru" => 'harga_sewa_baru',
                    "periode_awal" => 'periode_sewa_baru_d',
                    "periode_akhir" => 'periode_sewa_baru_sd',
                    'penawaran_th_1' => 'penawaran_th_1',
                    'penawaran_th_2' => 'penawaran_th_2',
                    'penawaran_th_3' => 'penawaran_th_3',
                    'penawaran_th_4' => 'penawaran_th_4',
                    'pemilik_1' => 'pemilik_1',
                    'pemilik_2' => 'pemilik_2',
                    'pemilik_3' => 'pemilik_3',
                    'pemilik_4' => 'pemilik_4',
                    'total_harga_sewa_baru' => 'total_harga_sewa_baru',
                    'keterangan_harga_patokan' => 'keterangan_harga_patokan',
                    'total_harga_baru' => 'total_harga_baru',
                    'durasi_sewa' => 'durasi_sewa',
                ], //group by SMR
                'BAN' => [
                    "tanggal_ban" => 'tanggal_ban', "pengelola" => 'pengelola', "nama_pic" => 'nama_pic', "nama_pic" => 'nama_pic', "alamat_pic" => 'alamat_pic', "jabatan_pic" => 'jabatan_pic',
                    "nomor_telepon_pic" => 'nomor_telepon_pic', 'tanggal_surat' => 'tgl_surat',
                ], //BAN
                'BAK' => [
                    "nomor_bak" => 'nomor_bak', "lokasi_tempat_sewa" => 'lokasi_tempat_sewa', "luas_tempat_sewa" => 'luas_tempat_sewa', "nomor_rekening" => 'nomor_rekening',
                    "pemilik_rekening" => 'pemilik_rekening', "cabang" => 'cabang', "nomor_npwp" => 'nomor_npwp', "pemilik_npwp" => 'pemilik_npwp', "nomor_shm_ajb_hgb" => 'nomor_shm_ajb_hgb',
                    "bank" => "bank", "nomor_surat_bak" => "no_surat",
                    "nomor_imb" => 'nomor_imb', "nomor_sppt_pbb" => 'nomor_sppt_pbb', "total_harga_net" => '',
                ],
            ];

            $cek_column = tmp_surat::where('site_id', $site_id)
                ->count();

            $filterjnis = strtolower($jenis);
            $passingvar = trim('nomor_surat_' . $filterjnis);

            if ($cek_column > 0) {
                $grep = tmp_surat::where('site_id', $site_id)->first();
                $getcolumn = $column_partial[$jenis];
                foreach ($getcolumn as $key => $value) {
                    $grep->site_id = $this->request->site_id;
                    $grep->$key = str_replace(['.', ','], '', $this->request->input($value));
                    if ($jenis == 'BAK') {
                        $grep->total_harga_net = str_replace(['.', ','], '', $bak_total_harga_net);
                    }
                }
                $filterjenis = ($grep->jenis_surat_id != $jenis) ? $jenis : '';
                if ($grep->jenis_surat_id != '') {
                    $grep->jenis_surat_id = $grep->jenis_surat_id . ',' . $filterjenis;
                } else {
                    $grep->jenis_surat_id = $jenis . ',' . $filterjenis;
                }
                $grep->save();
            } else {
                $create = new tmp_surat();
                $getcolumn = $column_partial[$jenis];
                foreach ($getcolumn as $key => $value) {
                    $create->site_id = $this->request->site_id;
                    if ($this->request->input($value) == 'harga_sewa_baru') {
                        $create->$key = str_replace(['.', ','], '', $this->request->input($value));
                    }
                    $create->$key = str_replace(['.', ','], '', $this->request->input($value));
                }
                $create->jenis_surat_id = str_replace(['.', ','], '', $jenis);
                $create->save();
            }
            $merger = array_merge([
                'periode_sewa_baru_d' => $this->request->periode_sewa_baru_d,
                'periode_sewa_baru_sd' => $this->request->periode_sewa_baru_sd,
                'penawaran_th_1' => $this->request->penawaran_th_1,
                'explode_tgl_date' => isset($fexplode_tgl_date) ? $fexplode_tgl_date : '',
                'sexplode_tgl_date' => $sexplode_tgl_date,
                'penawaran_th_2' => $this->request->penawaran_th_2,
                'penawaran_th_3' => $this->request->penawaran_th_3,
                'penawaran_th_4' => $this->request->penawaran_th_4,
                'pemilik_1' => $this->request->pemilik_1,
                'pemilik_2' => $this->request->pemilik_2,
                'pemilik_3' => $this->request->pemilik_3,
                'pemilik_4' => $this->request->pemilik_4,
                'harga_sewa_tahun' => $surat->nilai_sewa_tahun,
                'explode_tgl' => $explode_tgl,
                'no_surat' => $no_surat,
                'date_tgl_surat' => $this->request->tgl_surat,
                'tanggal_surat' => isset($this->request->tanggal_surat) ? $this->xmlEntities(Properti_app::tgl_indo($this->request->tanggal_surat)) : 0,
                'tgl_surat' => $tgl_srt,
                'hari' => $sexplode_tgl_date,
                'tanggal' => Properti_app::terbilang(date_format($kexplode_tgl_date, 'd')),
                'bulan' => Properti_app::terbilang($fexplode_tgl_date),
                'bulanf' => Properti_app::terbilang($fexplode_tgl_date),
                'tahunnya' => ucfirst(Properti_app::terbilang(Carbon::now()->format('Y'))),
                'nomor_surat_landlord' => $this->request->nomor_surat_landlord,
                'tanggal_surat_landlord' => isset($this->request->tanggal_surat_landlord) ? Properti_app::tgl_indo($this->request->tanggal_surat_landlord) : Properti_app::tgl_indo(date('Y-m-d')),
                'perihal_surat_landlord' => $this->request->perihal_surat_landlord,
                'penawaran_harga_sewa' => $this->request->penawaran_harga_sewa,
                'periode_sewa_penawaran' => $this->request->periode_sewa_penawaran,
                'pic_landlord' => $this->xmlEntities($this->request->pic_landlord),
                'jabatan_landlord' => $this->xmlEntities($this->request->jabatan_landlord),
                'periode_sewa_baru' => $this->request->periode_sewa_baru,
                'penawaran_pemilik' => $this->request->penawaran_pemilik,
                'penawaran_telkomsel' => $this->request->penawaran_telkomsel,
                'harga_sewa_baru' => $this->request->harga_sewa_baru,
                'harga_sewa' => $this->request->harga_sewa_baru,
                'pengelola' => $this->request->pengelola,
                'nama_pic' => $this->request->nama_pic,
                'nomor_pic' => $this->request->pic,
                'alamat_pic' => $this->request->alamat_pic,
                'nomor_telepon_pic' => $this->request->nomor_telepon_pic,
                'lokasi_tempat_sewa' => $this->request->lokasi_tempat_sewa,
                'luas_tempat_sewa' => $this->request->luas_tempat_sewa,
                'nomor_rekening' => $this->request->nomor_rekening,
                'pemilik_rekening' => $this->request->pemilik_rekening,
                'bank' => $this->request->bank,
                'cabang' => $this->request->cabang,
                'nomor_npwp' => $this->request->nomor_npwp,
                'pemilik_npwp' => $this->request->pemilik_npwp,
                'nomor_shm_ajb_hgb' => $this->request->nomor_shm_ajb_hgb,
                'nomor_imb' => $this->request->nomor_imb,
                'nomor_sppt_pbb' => $this->request->nomor_sppt_pbb,
                'psn_awal' => $this->xmlEntities($this->request->periode_sewa_penawaran_awal),
                'psn_akhir' => $this->request->periode_sewa_penawaran_akhir,
                'pic_name' => $this->request->nama_pic,
                'pejabat_pic' => $this->request->jabatan_pic,
                'alamat_site' => $surat->side_id,
                'no_pks' => $surat->nomor_pks,
                'nomor_telp_pic' => $this->request->no_telp_pic,
            ], [
                'id' => $surat->id,
                'site_id' => $surat->site_id,
                'site_name' => $surat->site_name,
                'nomor_pks' => $surat->nomor_pks,
                'alamat_site' => $this->xmlEntities($surat->alamat_site),
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
                'rata_revenue_perbulan' => isset($rata_revenue_perbulan) ? number_format($rata_revenue_perbulan, 0, 0, '.') : 0,
                'rata_reveenue_pertahun' => isset($rata_reveenue_pertahun) ? number_format($rata_reveenue_pertahun, 0, 0, '.') : 0,
                'kenaikan_harga_sewa' => isset($kenaikan_harga_sewa) ? round($kenaikan_harga_sewa, PHP_ROUND_HALF_EVEN) : 0,
                'total_harga_sewa' => $psr,
                'persentase_harga_sewa' => $number_rounded,
                'harga_patokan' => $surat->harga_patokan,
                'durasi_sewa' => $durasi_sw,
                'durasi_sw_bak' => $bkdurasi_sw,
                'periode_akhir' => $this->request->periode_akhir,
                'periode_awal' => $this->request->periode_awal,
                'total_harga_sewa_bak' => isset($sql->total_harga_sewa) ? $sql->total_harga_sewa : 0,
                'ket' => $ket,
                'bak_periode_sewa_awal' => isset($sql->periode_awal) ? $sql->periode_awal : 0,
                'bak_periode_sewa_akhir' => isset($sql->periode_akhir) ? $sql->periode_akhir : 0,
                'bak_lokasi_tempat_sewa' => isset($sql->lokasi_tempat_sewa) ? $sql->lokasi_tempat_sewa : '',
                'bak_luas_tempat_sewa' => isset($sql->luas_tempat_sewa) ? $sql->luas_tempat_sewa : '',
                'bak_durasi_sewa' => isset($sql->durasi_sewa) ? $sql->durasi_sewa : '',
                'bak_harga_sewa' => isset($sql->harga_sewa_baru) ? $sql->harga_sewa_baru : '',
                'bak_total_harga_sewa' => isset($sql->total_harga_sewa) ? $sql->total_harga_sewa : '',
                'bak_total_harga_net' => isset($bak_total_harga_net) ? number_format($bak_total_harga_net, 0, 0, '.') : 0,
                'bak_pengelola' => isset($sql->pengelola) ? $sql->pengelola : 0,
                'total_harga_baru' => number_format($this->request->total_harga_baru, 0, 0, '.'),

            ]);
            $cek_column = tmp_surat::where('site_id', $site_id)
                ->count();
            if ($cek_column > 0) {
                $tmsurat_id = tmp_surat::where('site_id', $site_id)->first();
                if ($jenis == 'SMR') {
                    $tmsurat_id->total_harga_sewa_baru = str_replace([',', '.', ''], '', $psr);
                    $tmsurat_id->keterangan_harga_patokan = $ket_temp;
                }
                $tmsurat_id->save();
            } else {
                if ($jenis == 'SMR') {
                    $create = new tmp_surat();
                    if ($jenis == 'SMR') {
                        $create->total_harga_sewa_baru = str_replace([',', '.', ''], '', $psr);
                        $create->keterangan_harga_patokan = $ket_temp;
                    }
                    $create->save();
                }
            }

            $log = new tmsurat_log;
            $log->site_id = $site_id;
            $log->site_name = $this->request->site_name;
            $log->jenis_surat = $jenis;
            $log->created_at = Carbon::now()->format('Y-m-d H:i:s');
            $log->updated_at = Carbon::now()->format('Y-m-d H:i:s');
            $log->user_id = 1;
            $log->save();

            $downloadj = 0;
            Tmsurat_master::where([
                'id' => $surat->id,
            ])->update([
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'download' => $downloadj + 1,
            ]);
            $fontStyle = new \PhpOffice\PhpWord\Style\Font();
            $suratword = new Word(storage_path('file/' . strtolower($jenis) . '.docx'));
            $suratword->setValues($merger);
            $fnamesite_id = str_replace(' ', '_', trim($surat->site_id));
            $filename = $jenis . '_' . $fnamesite_id . '_' . $this->request->site_name . time() . ".docx";
            $fontStyle->setName('Arial');
            $suratword->saveAs(public_path('download/' . $filename), 'Word2007', true);
            header("Cache-Control: public");
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=" . $filename);
            header("Content-Type: application/docx");
            header("Content-Transfer-Encoding: binary");

            return response()->json([
                'filename' => url('download/' . $filename),
            ]);
        }
    }
    // public function setTmpSurat($par)
    // {
    //     $this->
    // }
    public function update_surat()
    {
        // if ($this->request->ajax()) {

        // dd($this->request->all());
        $site_id = $this->request->id_site;
        $f = Tmsurat_master::where('site_id', $site_id)->first();
        $f->catatan = $this->request->catatan;
        $f->status_perpanjangan = $this->request->status_perpanjangan;
        $f->jenis_surat_id = isset($this->request->jenis_surat_id) ? $this->request->jenis_surat_id : '';
        $f->save();
        // }
    }

    public function report_surat()
    {
        $title = 'Laporan Data Surat';
        $jenis_surat = Jenis_surat::get();
        return view($this->view . 'index', compact('title', 'jenis_surat'));
    }
    public function log()
    {
        $title = 'Log Access Surat';
        return view($this->view . 'log', compact('title'));
    }

    public function surat_notif($jenis, $id)
    {
        // return $
        //    $data =  Tmsurat_master::where([
        //         'id' => $id
        //     ])->update([
        //         'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        //         'download' => $downloadj + 1
        //     ]);
    }

    public function destroy(Surat $surat)
    {
        try {
            if (is_array($this->request->id)) {
                $surat::whereIn('id', $this->request->id)->delete();
            } else {
                $surat::whereid($this->request->id)->delete();
            }

            return response()->json([
                'status' => 1,
                'msg' => 'Data berhasil di hapus',
            ]);
        } catch (Surat $t) {
            return response()->json([
                'status' => 2,
                'msg' => $t,
            ]);
        }
    }
}
