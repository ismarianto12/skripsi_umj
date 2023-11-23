<?php

namespace App\Http\Controllers;

use App\Helpers\Properti_app;
use App\Models\Tmrap;
use Illuminate\Http\Request;
use App\Models\Tmbangunan;
use App\Models\Tmjenisrap;
use App\Models\Tmproyek;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;


class TmrapController extends Controller
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
        $this->view    = '.tmrap.';
        $this->route   = 'master.tmrap.';
    }


    public function index()
    {
        $title = 'List Rencana Anggaran Proyek';
        $proyek = Tmproyek::get();
        return view($this->view . 'index', compact('title', 'proyek'));
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
        $tmjenisrap = Tmjenisrap::get();
        $bangunan = Tmbangunan::get();
        $proyek  = Tmproyek::get();
        $title = 'Input Rencana Anggaran Proyek';
        return view($this->view . 'form_add', compact('title', 'bangunan', 'proyek', 'tmjenisrap'));
    }


    public function api()
    {
        $tanggal         = $this->request->tanggal;
        $action          = $this->request->action;
        $sessionporyek   = Auth::user()->tmproyek_id;
        $tmproyek        = (Properti_app::propuser('tmlevel_id') == 1) ? $this->request->tmproyek_id : $sessionporyek;

        $data = Tmrap::with(['Tmproyek', 'Tmbangunan', 'Tmjenisrap', 'User']);

        if ($tanggal != '' and $action != '' and $action == 'caridata') {
            $par = $data->where(\DB::raw('date(create_at) as tanggal', $tanggal));
        } else {
            if ($this->request->tmproyek_id) {
                $par =  $data->where('tmproyek_id', $tmproyek);
            } else {
                $par = $data;
            }
        }
        $getall = $par->get();
        return DataTables::of($getall)
            ->editColumn('id', function ($p) {
                return "<input type='checkbox' name='cbox[]' value='" . $p->id . "' />";
            })
            ->editColumn('action', function ($p) {
                return  '<a href="" class="btn btn-warning btn-xs" id="edit" data-id="' . $p->id . '"><i class="fa fa-edit"></i>Edit </a> ';
            }, true)

            ->editColumn('namaproyek', function ($p) {
                return ($p->tmproyek->nama_proyek) ? $p->Tmproyek->nama_proyek : 'Data kosong';
            }, true)

            ->editColumn('namabangunan', function ($p) {
                return isset($p->Tmbangunan->nama_bangunan) ? $p->Tmbangunan->nama_bangunan : 'Data kosong';
            }, true)

            ->editColumn('jenisrapnama', function ($p) {
                return isset($p->Tmjenisrap->nama_rap) ? $p->Tmjenisrap->nama_rap : 'Data kosong';
            }, true)

            ->editColumn('usercreate', function ($p) {
                return isset($p->User->name) ? $p->User->name : 'kosong';
            }, true)
            ->addIndexColumn()
            ->rawColumns([
                'namaproyek',
                'namabangunan',
                'jenisrapnama',
                'usercreate',
                'action',
                'id'
            ])
            ->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        //
        $this->request->validate([
            'tmproyek_id' => 'required',
            'tmbangunan_id' => 'required',
            'tmjenisrap_id' => 'required',
            'pekerjaan' => 'required',
            'volume' => 'required',
            'satuan' => 'required',
            'harga_satuan' => 'required',
            'jumlah_harga' => 'required',
        ]);
        try {
            $data = new Tmrap;
            $data->tmproyek_id = $this->request->tmproyek_id;
            $data->tmbangunan_id = $this->request->tmbangunan_id;
            $data->tmjenisrap_id = $this->request->tmjenisrap_id;
            $data->pekerjaan = $this->request->pekerjaan;
            $data->volume = $this->request->volume;
            $data->satuan = $this->request->satuan;
            $data->harga_satuan = str_replace(',', '', $this->request->harga_satuan);
            $data->jumlah_harga = $this->request->jumlah_harga;
            $data->user_id = Auth::user()->id;
            $data->tanggal = Carbon::now()->format('Y-m-d');
            $data->save();
            return response()->json([
                'status' => 2,
                'data berhasil di simpan'
            ]);
        } catch (\App\Models\Tmrap $th) {
            return response()->json([
                'status' => 2,
                $th
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
        $data = Tmrap::findOrFail($id);
        $proyek = Tmproyek::get();
        $tmjenisrap = Tmjenisrap::get();
        $bangunan = Tmbangunan::get();

        $tmproyek_id = $data->tmproyek_id;
        $tmbangunan_id = $data->tmbangunan_id;
        $tmjenisrap_id = $data->tmjenisrap_id;
        $pekerjaan = $data->pekerjaan;
        $volume = $data->volume;
        $satuan = $data->satuan;
        $harga_satuan = $data->harga_satuan;
        $jumlah_harga = $data->jumlah_harga;
        $user_id = $data->user_id;
        $id = $data->id;

        return view($this->view . 'form_edit', compact(
            'proyek',
            'tmjenisrap',
            'bangunan',
            'tmproyek_id',
            'tmbangunan_id',
            'tmjenisrap_id',
            'pekerjaan',
            'volume',
            'satuan',
            'harga_satuan',
            'jumlah_harga',
            'user_id',
            'id',
        ));
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
        try {
            $data = Tmrap::find($id);
            $data->tmproyek_id = $this->request->tmproyek_id;
            $data->tmbangunan_id = $this->request->tmbangunan_id;
            $data->tmjenisrap_id = $this->request->tmjenisrap_id;
            $data->pekerjaan = $this->request->pekerjaan;
            $data->volume = $this->request->volume;
            $data->satuan = $this->request->satuan;
            $data->harga_satuan = str_replace(',', '', $this->request->harga_satuan);
            $data->jumlah_harga = $this->request->jumlah_harga;
            $data->user_id = Auth::user()->id;
            $data->tanggal = Carbon::now()->format('Y-m-d');
            $data->save();
            // dd($this->request);

            return response()->json([
                'status' => 2,
                'data berhasil di simpan'
            ]);
        } catch (\App\Models\Tmrap $th) {
            return response()->json([
                'status' => 2,
                $th
            ]);
        }
    }
    // load data table with load model int 
    public function datatablelrap()
    {
        // this line description at datable when im click that .
        $title = 'Pilih data di list table';
        return view($this->view . 'index_tmrspktanggal', compact('title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            if (is_array($this->request->id))
                Tmrap::whereIn('id', $this->request->id)->delete();
            else
                Tmrap::whereid($this->request->id)->delete();
            return response()->json([
                'status' => 1,
                'msg' => 'Data berhasil di hapus'
            ]);
        } catch (Tmrap $t) {
            return response()->json([
                'status' => 2,
                'msg' => $t
            ]);
        }
    }
}
