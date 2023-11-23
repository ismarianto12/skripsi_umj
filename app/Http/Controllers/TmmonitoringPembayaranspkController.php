<?php

namespace App\Http\Controllers;

use App\Models\Tmmonitoring_pembayaranspk;
use App\Models\Tmproyek;
use App\Models\Tmjenisrap;
use App\Models\Tmbangunan;
use App\Models\Tmrspk;
use App\Models\Trvendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tmrap;
use App\Models\Tmprogres_spk;

use DataTables;

class TmmonitoringPembayaranspkController extends Controller
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
        $this->view    = '.tmmonitoringspk.';
        $this->route   = 'master.monitoringspk.';
    }


    public function index()
    {

        // \dd(Auth::user()->Tmlevel->level_kode);
        $title = 'Monitoring Pembayaran SPK';
        return view($this->view . 'index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!$this->request->ajax()) {
            return redirect(route('home'));
            exit();
        }
        $datas = Tmrspk::join('tmrap', 'tmrap.id', '=', 'tmrspk.tmrap_id')
            ->join('tmproyek', 'tmproyek.id', '=', 'tmrap.tmproyek_id')
            ->select('tmrspk.no_spk', 'tmproyek.nama_proyek', 'tmrspk.id')
            ->get();

        $title = 'Tambah Monitoring pembayaran spk';
        return view($this->view . 'form_add', [
            'tmrspk' => $datas
        ]);
    }

    // public function dataspk()
    // {
    //     $level = Auth::user()->levelid;
    //     $tmproyek_id  = Auth::user()->tmproyek_id;
    //     $id = $this->request->id;
    //     $data = Tmrspk::select(
    //         'tmrspk.tmproyek_id',
    //         'tmrspk.tmbangunan_id',
    //         'tmrspk.tmjenisrap_id',
    //         'tmrspk.trvendor_id',
    //         'tmrspk.pekerjaan',
    //         'tmrspk.spk_volume',
    //         'tmrspk.no_spk',
    //         'tmproyek.kode',
    //         'tmproyek.nama_proyek',
    //         'tmproyek.tmbangunan_id',
    //         'tmproyek.tmlevel_id',
    //         'users.username',
    //         'users.name'
    //     )
    //         ->join('tmproyek', 'tmrspk.tmproyek_id', '=', 'tmproyek.id')
    //         ->join('users', 'tmproyek.id', '=', 'users.tmproyek_id');

    //     if ($level == 1) {
    //         $f =   $data->get();
    //     } else if ($level == 2) {
    //         $f =  $data->where('user.tmproyek_id', $tmproyek_id)->get();
    //     }
    //     return $f;
    // }


    public function api()
    {
        $data     = Tmmonitoring_pembayaranspk::with(['Tmrspk', 'User'])->get();
        $tmrspk   = new Tmrspk;
        return DataTables::of($data)
            ->editColumn('id', function ($p) {
                return "<input type='checkbox' name='cbox[]' value='" . $p->id . "' />";
            })
            ->editColumn('action', function ($p) {
                return  '<a href="" class="btn btn-warning btn-xs" id="edit" data-id="' . $p->id . '"><i class="fa fa-edit"></i>Edit </a> ';
            }, true)

            ->editColumn('usercreate', function ($p) {
                return isset($p->User->name) ? $p->User->name : "Kosong";
            }, true)
            ->editColumn('status_bayar', function ($p) use ($tmrspk) {
                $cmspk   = $tmrspk->find($p->tmpspk_id);
                $ket     = ($p->spk_bayar_tot == $cmspk['spk_jumlah_harga']) ? 1
                    : 2;
                if ($ket == 1) {
                    $status = '<button class="btn btn-success btn-sm">Lunas</buton>';
                } else {
                    $status = '<button class="btn btn-danger btn-sm">Belum Lunas</buton>';
                }
                return $status;
            }, true)
            ->addIndexColumn()
            ->rawColumns([
                'namaproyek',
                'namabangunan',
                'vendorname',
                'jenisrapnama',
                'usercreate',
                'status_bayar',
                'action',
                'id'
            ])
            ->toJson();
    }

    public function replace_com($param)
    {
        return str_replace(',', '', $param);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this->request->validate([
            'no_spk' => 'required',
            'tmrspk_id' => 'required',
            'periode_awal' => 'required',
            'periode_akhir' => 'required',
            'spk_harga_progres' => 'required',
            'spk_bayar_lalu' => 'required',
            'spk_bayar_sekarang' => 'required',
            'spk_bayar_tot' => 'required',
            'spk_byr_sisa_lalu' => 'required',
            'spk_bayar_sisa_skrg' => 'required',
            'spk_byr_sisa_total' => 'required'
        ]);
        $fspk_harga_progres = $this->replace_com($this->request->spk_harga_progres);
        $fspk_bayar_lalu =  $this->replace_com($this->request->spk_bayar_lalu);
        $fspk_bayar_sekarang =  $this->replace_com($this->request->spk_bayar_sekarang);
        $fspk_bayar_tot =  $this->replace_com($this->request->spk_bayar_tot);
        $fspk_byr_sisa_lalu =  $this->replace_com($this->request->spk_byr_sisa_lalu);
        $fspk_bayar_sisa_skrg =  $this->replace_com($this->request->spk_bayar_sisa_skrg);
        $fspk_byr_sisa_total =  $this->replace_com($this->request->spk_byr_sisa_total);

        // cek jika ada
        $tmrspk       = Tmrspk::find($this->request->tmrspk_id);
        $tmmonitoring = Tmmonitoring_pembayaranspk::where('tmpspk_id', $tmrspk->id);
        $tspk_bayar_tot =  $this->replace_com($this->request->spk_bayar_tot);
        if ($tmmonitoring->count() > 0) {
            $nilai = ($fspk_bayar_lalu + $fspk_bayar_sekarang);
            $chek_tmspkbyr  = $tmmonitoring->where(['spk_bayar_tot' => $nilai])->first();
            $chek_tmspkbyrs = isset($chek_tmspkbyr['spk_bayar_tot']) ? $chek_tmspkbyr['spk_bayar_tot'] : 0;

            $cmspk   = Tmrspk::find($this->request->tmrspk_id);
            $ket     = ($chek_tmspkbyrs >= $cmspk['spk_jumlah_harga']) ? 1
                : 2;

            if ($chek_tmspkbyrs == $tspk_bayar_tot) {
                $pesan = 'Total bayar spk sudah ada';
                return response()->json(['errors' => ['Total Bayar SPK' => [$pesan]]], 422);
            } else if ($ket == 1) {
                $pesan = 'Monitoring Spk sudah Lunas';
                return response()->json(['errors' => ['Total Bayar SPK' => [$pesan]]], 422);
            }
        }
        try {
            //code...
            $f = new Tmmonitoring_pembayaranspk;
            $f->no_spk = $this->request->no_spk;
            $f->tmpspk_id = $this->request->tmrspk_id;
            $f->periode_awal = $this->request->periode_awal;
            $f->periode_akhir = $this->request->periode_akhir;
            $f->spk_harga_progres = $this->replace_com($this->request->spk_harga_progres);
            $f->spk_bayar_lalu =  $this->replace_com($this->request->spk_bayar_lalu);
            $f->spk_bayar_sekarang =  $this->replace_com($this->request->spk_bayar_sekarang);
            $f->spk_bayar_tot =  $this->replace_com($this->request->spk_bayar_tot);
            $f->spk_byr_sisa_lalu =  $this->replace_com($this->request->spk_byr_sisa_lalu);
            $f->spk_bayar_sisa_skrg =  $this->replace_com($this->request->spk_bayar_sisa_skrg);
            $f->spk_byr_sisa_total =  $this->replace_com($this->request->spk_byr_sisa_total);
            $f->persentase = $this->request->percentage_id;

            $f->user_id = Auth::user()->id;
            $f->save();

            return response()->json([
                'status' => 1,
                'msg' => 'Data berhasil di simpan',
            ]);
        } catch (Tmmonitoring_pembayaranspk $th) {
            return response()->json([
                'status' => 1,
                'msg' => 'Data gagal di tambahkan' . $th,
            ]);
        }
    }


    // public function carperse($id_sk)
    // {
    //     # code...
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function gettotal_lalu()
    {
        $tmpspk_id = $this->request->tmrspk_id;
        $jum =   Tmmonitoring_pembayaranspk::select(\DB::raw('sum(spk_bayar_sekarang) as jumlah_lalu'))
            ->where('tmpspk_id', $tmpspk_id)->first();
        return response()->json(['spk_byr_sisa_lalu' => $jum['jumlah_lalu']]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        if (!$this->request->ajax()) {
            return response()->json([
                'data' => 'data null',
                'aspx' => 'response aspx fail '
            ]);
        }
        $title = 'Tambah monitoring pembayaran spk';
        $datas = Tmrspk::join('tmrap', 'tmrap.id', '=', 'tmrspk.tmrap_id')
            ->join('tmproyek', 'tmproyek.id', '=', 'tmrap.tmproyek_id')
            ->select('tmrspk.no_spk', 'tmproyek.nama_proyek', 'tmrspk.id')
            ->get();

        $data = Tmmonitoring_pembayaranspk::find($id);
        return view($this->view . 'form_edit', [
            'no_spk' => $data->no_spk,
            'tmrspk_id' => $data->tmpspk_id,
            'periode_awal' => $data->periode_awal,
            'periode_akhir' => $data->periode_akhir,
            'spk_harga_progres' => $data->spk_harga_progres,
            'spk_bayar_lalu' => $data->spk_bayar_lalu,
            'spk_bayar_skrg' => $data->spk_bayar_sekarang,
            'spk_bayar_tot' => $data->spk_bayar_tot,
            'spk_bayar_sisa_lalu' => $data->spk_byr_sisa_lalu,
            'spk_bayar_sisa_skrg' => $data->spk_bayar_sisa_skrg,
            'spk_byr_sisa_total' => $data->spk_byr_sisa_total,
            'persentase' => $data->persentase,
            'user_id' => $data->user_id,
            'id' => $data->id,
            'tmrspk' => $datas
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->request->validate([
            'tmrspk_id' => 'required',
            'periode_awal' => 'required',
            'periode_akhir' => 'required',
            'spk_harga_progres' => 'required',
            'spk_bayar_lalu' => 'required',
            'spk_bayar_sekarang' => 'required',
            'spk_bayar_tot' => 'required',
            'spk_byr_sisa_lalu' => 'required',
            'spk_bayar_sisa_skrg' => 'required',
            'spk_byr_sisa_total' => 'required',

        ]);
        try {
            //code...
            $f = Tmmonitoring_pembayaranspk::find($id);
            $f->no_spk = $this->request->no_spk;
            $f->tmpspk_id = $this->request->tmrspk_id;
            $f->periode_awal = $this->request->periode_awal;
            $f->periode_akhir = $this->request->periode_akhir;
            $f->spk_harga_progres = $this->replace_com($this->request->spk_harga_progres);
            $f->spk_bayar_lalu =  $this->replace_com($this->request->spk_bayar_lalu);
            $f->spk_bayar_sekarang =  $this->replace_com($this->request->spk_bayar_sekarang);
            $f->spk_bayar_tot =  $this->replace_com($this->request->spk_bayar_tot);
            $f->spk_byr_sisa_lalu =  $this->replace_com($this->request->spk_byr_sisa_lalu);
            $f->spk_bayar_sisa_skrg =  $this->replace_com($this->request->spk_bayar_sisa_skrg);
            $f->spk_byr_sisa_total =  $this->replace_com($this->request->spk_byr_sisa_total);
            $f->persentase = $this->request->percentage_id;

            $f->user_id = Auth::user()->id;
            $f->save();

            return response()->json([
                'status' => 1,
                'msg' => 'Data berhasil di simpan',
            ]);
        } catch (Tmmonitoring_pembayaranspk $th) {
            return response()->json([
                'status' => 1,
                'msg' => 'Data gagal di tambahkan' . $th,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->tmlevel_id == 2) {
            $pesan = 'anda tidak di perkenankan untuk menghapus data';
            return response()->json(['errors' => ['volume_spk' => [$pesan]]], 422);
        } else {
            try {
                if (is_array($this->request->id))
                    Tmmonitoring_pembayaranspk::whereIn('id', $this->request->id)->delete();
                else
                    Tmmonitoring_pembayaranspk::whereid($this->request->id)->delete();
                return response()->json([
                    'status' => 1,
                    'msg' => 'Data berhasil di hapus'
                ]);
            } catch (Tmmonitoring_pembayaranspk $t) {
                return response()->json([
                    'status' => 2,
                    'msg' => $t
                ]);
            }
        }
    }
}
