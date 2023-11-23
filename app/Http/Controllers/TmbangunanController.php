<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tmbangunan;
use DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\Tmproyek;

class TmbangunanController extends Controller
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
        $this->view    = '.tmbangunan.';
        $this->route   = 'master.tmbangunan.';
    }


    public function index()
    {
        $title = 'Master Data Bangunan';
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
        $title = 'Tambah Data Bangunan';
        return view($this->view . 'form_add', compact('title'));
    }

    public function getbangunan()
    {
        $title = 'Master Data Bangunan';
        return view($this->view . 'select', compact('title'));
    }

    public function api()
    {
        $data = Tmbangunan::with(['User', 'Tmproyek'])->get();
        return DataTables::of($data)
            ->editColumn('id', function ($p) {
                return "<input type='checkbox' name='cbox[]' value='" . $p->id . "' />";
            })
            ->editColumn('action', function ($p) {
                return  '<a href="" class="btn btn-warning btn-xs" id="edit" data-id="' . $p->id . '"><i class="fa fa-edit"></i>Edit </a> ';

            }, true)
            ->editColumn('nama', function ($p) {
                return $p->name;
            }, true)
            ->editColumn('proyek_name', function ($p) {
                return isset($p->Tmproyek->nama_proyek) ? $p->Tmproyek->nama_proyek : 'Kosong';
            }, true)
            ->addIndexColumn()
            ->rawColumns(['usercreate', 'proyek_name', 'action', 'id'])
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
        $this->request->validate([
            'kode' => 'required|unique:tmbangunan,kode',
            'nama_bangunan' => 'required|unique:tmbangunan,nama_bangunan',
            'tmproyek_id' => 'required',
            'ukuran' => 'required',
            'lokasi' => 'required',
            'type' => 'required',
            'deskripsi' => 'required',
        ]);
        try {
            $data = new Tmbangunan();
            $data->kode = $this->request->kode;
            $data->nama_bangunan = $this->request->nama_bangunan;
            $data->tmproyek_id = $this->request->tmproyek_id;
            $data->ukuran = $this->request->ukuran;
            $data->lokasi = $this->request->lokasi;
            $data->type = $this->request->type;
            $data->deskripsi = $this->request->deskripsi;

            $data->user_id = Auth::user()->id;
            $data->save();

            return response()->json([
                'status' => 1,
                'msg' => 'data bangunana berhasil dtambah'
            ]);
        } catch (\Tmbangunan $t) {
            return response()->json([
                'status' => 1,
                'msg' =>  $t,
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
        $data = Tmbangunan::findOrfail($id);
        return view($this->view . 'form_edit', [
            'kode' => $data->kode,
            'nama_bangunan' => $data->nama_bangunan,
            'tmproyek_id' => $data->tmproyek_id,
            'ukuran' => $data->ukuran,
            'lokasi' => $data->lokasi,
            'type' => $data->type,
            'deskripsi' => $data->deskripsi,
            'id' => $data->id
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $this->request->validate([
            'nama_bangunan' => 'required',
            'ukuran' => 'required',
            'lokasi' => 'required',
            'type' => 'required',
            'deskripsi' => 'required'
        ]);
        try {
            $data = Tmbangunan::find($id);
            $data->kode = $this->request->kode;
            $data->nama_bangunan = $this->request->nama_bangunan;
            $data->ukuran = $this->request->ukuran;
            $data->lokasi = $this->request->lokasi;
            $data->type = $this->request->type;
            $data->deskripsi = $this->request->deskripsi;
            $data->tmproyek_id = $this->request->tmproyek_id;
            $data->user_id = Auth::user()->id;
            $data->save();

            return response()->json([
                'status' => 1,
                'msg' => 'data bangunana berhasil dtambah'
            ]);
        } catch (\Tmbangunan $t) {
            return response()->json([
                'status' => 1,
                'msg' =>  $t,
            ]);
        }
    }
    public function caribangunan()
    {
        $id = $this->request->id;
        $data = Tmbangunan::select('tmbangunan.nama_bangunan', 'tmbangunan.id')
            ->where('tmproyek_id', $id)
            ->get();
        return response()->json($data);
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
                    Tmbangunan::whereIn('id', $this->request->id)->delete();
                else
                    Tmbangunan::whereid($this->request->id)->delete();
                return response()->json([
                    'status' => 1,
                    'msg' => 'Data berhasil di hapus'
                ]);
            } catch (Tmbangunan $t) {
                return response()->json([
                    'status' => 2,
                    'msg' => $t
                ]);
            }
        }
    }
}
