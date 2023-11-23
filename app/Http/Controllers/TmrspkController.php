<?php

namespace App\Http\Controllers;

use App\Helpers\Properti_app;
use App\Models\Tmrspk;
use App\Models\Tmproyek;
use App\Models\Tmjenisrap;
use App\Models\Tmbangunan;
use App\Models\Tmprogres_spk;
use App\Models\Tmrap;
use App\Models\Trvendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Illuminate\Support\Carbon;

class TmrspkController extends Controller
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
        $this->view    = '.tmrspk.';
        $this->route   = 'master.tmrspk.';
    }


    public function index()
    {
        $title = 'Master Surat Perintah Kerja ';
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
        $datas = Tmrap::select(
            \DB::raw('date(tmrap.created_at) as tanggal'),
            'tmrap.id as id_rap',
            'tmrap.tmproyek_id',
            'tmrap.pekerjaan',
            'tmrap.tmjenisrap_id',
            'tmrap.volume',
            'tmrap.satuan',
            'tmrap.tmbangunan_id',
            'tmrap.harga_satuan',
            'tmrap.jumlah_harga',
            'tmproyek.id',
            'tmproyek.kode',
            'tmproyek.nama_proyek'
        )
            ->join('tmjenisrap',  'tmrap.tmjenisrap_id', '=', 'tmjenisrap.id')
            ->join('tmproyek',  'tmproyek.id', '=', 'tmrap.tmproyek_id')
            ->get();

        $title = 'Tambah Tmrspk';
        return view($this->view . 'form_add', [
            'proyek' => Tmproyek::get(),
            'tmrapdatas' => $datas,
            'tmjenisrap' => Tmjenisrap::get(),
            'bangunan' => Tmbangunan::get(),
            'trvendor' => Trvendor::get()
        ]);
    }


    public function api()
    {

        $data = Tmrspk::with(['Tmrap', 'User', 'Trvendor'])
            ->get();

        // dd($data); 
        $tmproyek = new Tmproyek;
        $tmbangunan = new Tmbangunan;
        $tmjenisrap = new Tmjenisrap;

        return DataTables::of($data)
            ->editColumn('id', function ($p) {
                return "<input type='checkbox' name='cbox[]' value='" . $p->id . "' />";
            })
            ->editColumn('namaproyek', function ($p) use ($tmproyek) {
                $data =   $tmproyek->where('id', $p->Tmrap->tmproyek_id)->first();
                return isset($data->nama_proyek) ? $data->nama_proyek : 'kosong';
            })
            ->editColumn('namabangunan', function ($p) use ($tmbangunan) {
                $data =   $tmbangunan->where('id', $p->Tmrap->tmbangunan_id)->first();
                return isset($data->nama_bangunan) ? $data->nama_bangunan : 'kosong';
            })
            ->editColumn('tanggal', function ($p) {
                return isset($p->tanggal) ? $p->tanggal : 'kosong';
            })
            ->editColumn('vendorname', function ($p) {
                return isset($p->Trvendor->nama) ? $p->Trvendor->nama : 'kosong';
            })
            ->editColumn('jenisrapnama', function ($p) use ($tmjenisrap) {
                $data =   $tmjenisrap->where('id', $p->Tmrap->tmjenisrap_id)->first();
                return isset($data->nama_rap) ? $data->nama_rap : 'kosong';
            })
            ->editColumn('pekerjaan', function ($p) {
                return isset($p->pekerjaan) ? $p->pekerjaan : 'kosong';
            })
            ->editColumn('volume', function ($p) {
                return isset($p->volume) ? $p->volume : 'kosong';
            })
            ->editColumn('satuan', function ($p) {
                return isset($p->satuan) ? $p->satuan : 'kosong';
            })

            ->editColumn('usercreate', function ($p) {
                return isset($p->User->name) ? $p->User->name : "Kosong";
            }, true)
            ->editColumn('action', function ($p) {
                return  '<a href="" class="btn btn-warning btn-xs" id="edit" data-id="' . $p->id . '"><i class="fa fa-edit"></i>Edit </a> ';
            }, true)
            ->addIndexColumn()
            ->rawColumns([
                'id',
                'namaproyek',
                'namabangunan',
                'tanggal',
                'vendorname',
                'jenisrapnama',
                'pekerjaan',
                'volume',
                'satuan',
                'spk_harga_satuan',
                'spk_jumlah_harga',
                'usercreate',
                'action'
            ])
            ->toJson();
    }

    private function getcount($tmrap_id)
    {
        $data = Tmrap::select(
            \DB::raw("sum(volume) as total_volume_rap")
        )->find($tmrap_id);
        return $data;
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
            'tmrap_id' => 'required',
            'trvendor_id' => 'required',
            'no_spk' =>  'required',
            'jenis_rap' =>  'required',
            'pekerjaan' =>  'required',
            'volume' => 'required',
            'volume_rspk' =>  'required',
            'satuan' =>  'required',
            'spk_harga_satuan' =>  'required',
            'spk_jumlah_harga' =>  'required',

        ]);
        $tmrap_id = $this->request->tmrap_id;
        $check = $this->getcount($tmrap_id);
        // dd($check);

        if ($check->total_volume_rap > 1) {
            if ($this->request->volume_rspk > $check->total_volume_rap) {
                $pesan = 'Nilai volume rap lebih besar dari spk';
            } else {
                $pesan = 1;
            }
        } else {
            $pesan = 'Tidak bisa menambhkan karena jumlah volume spk yang di pilih sama dengan 0';
        }
        if ($pesan != 1) {
            return response()->json(['errors' => ['volume_spk' => [$pesan]]], 422);
        }
        try {
            //code...
            $ff = new Tmrspk;
            $ff->tmrap_id = $this->request->tmrap_id;
            $ff->trvendor_id = $this->request->trvendor_id;
            $ff->no_spk = $this->request->no_spk;
            $ff->pekerjaan = $this->request->pekerjaan;
            $ff->volume = $this->request->volume_rspk;
            $ff->satuan = str_replace(',', '', $this->request->satuan);
            $ff->spk_harga_satuan = str_replace(',', '', $this->request->spk_harga_satuan);
            $ff->spk_jumlah_harga = str_replace(',', '', $this->request->spk_jumlah_harga);
            $ff->user_id = Auth::user()->id;
            $ff->tanggal = Carbon::now()->format('Y-m-d');
            $ff->save();

            // update rap table if value equal null;
            $rap = Tmrap::find($tmrap_id);
            $nilai_upd  = $rap->volume - $this->request->volume_rspk;
            $rap->volume = $nilai_upd;
            $rap->save();

            return response()->json([
                'status' => 1,
                'msg' => 'Data berhasil di simpan',
            ]);
        } catch (Tmrspk $th) {
            return response()->json([
                'status' => 1,
                'msg' => 'Data gagal di tambahkan' . $th,
            ]);
        }
    }

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
        $datas = Tmrap::select(
            \DB::raw('date(tmrap.created_at) as tanggal'),
            'tmrap.id as id_rap',
            'tmrap.tmproyek_id',
            'tmrap.pekerjaan',
            'tmrap.tmjenisrap_id',
            'tmrap.volume',
            'tmrap.satuan',
            'tmrap.tmbangunan_id',
            'tmrap.harga_satuan',
            'tmrap.jumlah_harga',
            'tmproyek.id',
            'tmproyek.kode',
            'tmproyek.nama_proyek'
        )
            ->join('tmjenisrap',  'tmrap.tmjenisrap_id', '=', 'tmjenisrap.id')
            ->join('tmproyek',  'tmproyek.id', '=', 'tmrap.tmproyek_id')
            ->get();

        $title = 'Tambah Tmrspk';
        $data = Tmrspk::findOrfail($id);
        return view($this->view . 'form_edit', [
            'proyek' => Tmproyek::get(),
            'tmjenisrap' => Tmjenisrap::get(),
            'bangunan' => Tmbangunan::get(),
            'trvendor' => Trvendor::get(),
            'tmproyek_id' => $data->tmproyek_id,
            'tmrap_id' => $data->tmrap_id,
            'tmbangunan_id' => $data->tmbangunan_id,
            'tmvendor_id' => $data->tmvendor_id,
            'tmjenisrap_id' => $data->tmjenisrap_id,
            'no_spk' => $data->no_spk,
            'pekerjaan' => $data->pekerjaan,
            'volume' => $data->volume,
            'satuan' => $data->satuan,
            'spk_harga_satuan' => $data->spk_harga_satuan,
            'spk_jumlah_harga' => $data->spk_jumlah_harga,
            'tanggal' => $data->tanggal,
            'id' => $data->id,
            'tmrapdatas' => $datas
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
            'tmrap_id' => 'required',
            'trvendor_id' => 'required',
            'no_spk' =>  'required',
            'pekerjaan' =>  'required',
            'volume' => 'required',
            'volume_rspk' =>  'required',
            'satuan' =>  'required',
            'spk_harga_satuan' =>  'required',
            'spk_jumlah_harga' =>  'required'
        ]);
        $tmrap_id = $this->request->tmrap_id;
        $check = $this->getcount($tmrap_id);
        // dd($check); 
        if ($check->total_volume_rap > 1) {
            if ($this->request->volume_rspk > $check->total_volume_rap) {
                $pesan = 'Nilai volume rap lebih besar dari spk';
            } else {
                $pesan = 1;
            }
        } else {
            $pesan = 'Tidak bisa menambhkan karena jumlah volume spk yang di pilih sama dengan 0';
        }
        if ($pesan != 1) {
            return response()->json(['errors' => ['volume_spk' => [$pesan]]], 422);
        }

        try {
            //code...
            $ff = Tmrspk::find($id);
            $ff->tmrap_id = $this->request->tmrap_id;
            $ff->trvendor_id = $this->request->trvendor_id;
            $ff->no_spk = $this->request->no_spk;
            $ff->pekerjaan = $this->request->pekerjaan;
            $ff->volume = $this->request->volume_rspk;
            $ff->satuan = str_replace(',', '', $this->request->satuan);
            $ff->spk_harga_satuan = str_replace(',', '', $this->request->spk_harga_satuan);
            $ff->spk_jumlah_harga = str_replace(',', '', $this->request->spk_jumlah_harga);
            $ff->user_id = Auth::user()->id;
            $ff->tanggal = Carbon::now()->format('Y-m-d');
            $ff->save();

            // update to minus volume that is availablle
            $rap = Tmrap::find($tmrap_id);
            $nilai_upd  = $rap->volume - $this->request->volume_rspk;
            $rap->volume = $nilai_upd;
            $rap->save();


            return response()->json([
                'status' => 1,
                'msg' => 'Data berhasil di update',
            ]);
        } catch (Tmrspk $th) {
            return response()->json([
                'status' => 1,
                'msg' => 'Data gagal di tambahkan' . $th,
            ]);
        }
    }

    public function searchspk()
    {
        $level        = Auth::user()->levelid;
        $tmproyek_id  = Auth::user()->tmproyek_id;
        $id           = $this->request->id;
        $data = Tmrspk::select(
            'tmrspk.tmrap_id',
            'tmrspk.trvendor_id',
            'tmrspk.no_spk',
            'tmrspk.tanggal',
            'tmrspk.pekerjaan',
            'tmrspk.volume',
            'tmrspk.satuan',
            'tmrspk.spk_harga_satuan',
            'tmrspk.spk_jumlah_harga',
            'tmprogres_spk.periode_awal',
            'tmprogres_spk.periode_akhir',
            'tmprogres_spk.spk_progress_lalu',
            'tmprogres_spk.spk_progress_skg',
            'tmprogres_spk.spk_progress_tot',
            'tmprogres_spk.spk_harga_progres',
            'tmprogres_spk.spk_harga_sisa',
            'tmproyek.nama_proyek'
        )
            ->join('tmprogres_spk', 'tmprogres_spk.tmrspk_id', '=', 'tmrspk.id', 'LEFT')
            ->join('tmrap', 'tmrspk.id', '=', 'tmrap.id', 'LEFT')
            ->join('tmproyek', 'tmrap.tmproyek_id', '=', 'tmproyek.id', 'LEFT');

        if ($level == 1) {
            $f =  $data->where([
                'tmrspk.id' => $id
            ])->first();
        } else if ($level == 2) {
            $f =  $data->where([
                'tmrspk.id' => $id,
                'user.tmproyek_id' => $tmproyek_id
            ])->first();
        }
        return response()->json($f);
    }
    public function searchrap()
    {

        $tmproyek_id = Auth::user()->proyek_id;
        $tmrap_id  = $this->request->tmrap_id;
        $level_access = Properti_app::propuser('tmlevel_id');
        $datas = Tmrap::select(
            'tmrap.id',
            'tmrap.tmproyek_id',
            'tmrap.pekerjaan',
            'tmrap.tmjenisrap_id',
            'tmrap.volume',
            'tmrap.satuan',
            'tmrap.tmbangunan_id',
            'tmrap.harga_satuan',
            'tmrap.jumlah_harga',
            'tmproyek.kode',
            'tmproyek.nama_proyek',
            'tmjenisrap.kode_rap',
            'tmjenisrap.nama_rap'
        )
            ->join('tmjenisrap',  'tmrap.tmjenisrap_id', '=', 'tmjenisrap.id')
            ->join('tmproyek',  'tmproyek.id', '=', 'tmrap.tmproyek_id')
            ->join('tmbangunan',  'tmbangunan.id', '=', 'tmrap.tmbangunan_id');

        if ($level_access == 1) {
            $datas->where('tmrap.id', $tmrap_id);
        } else {
            $datas->where(['tmrap.id' => $tmrap_id, 'tmrap.tmproyek_id' => $tmproyek_id]);
        }
        $result = $datas->first();
        return response()->json($result);
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
                    Tmrspk::whereIn('id', $this->request->id)->delete();
                else
                    Tmrspk::whereid($this->request->id)->delete();
                return response()->json([
                    'status' => 1,
                    'msg' => 'Data berhasil di hapus'
                ]);
            } catch (Tmrspk $t) {
                return response()->json([
                    'status' => 2,
                    'msg' => $t
                ]);
            }
        }
    }
}
