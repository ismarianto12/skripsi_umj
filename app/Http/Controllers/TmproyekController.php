<?php

namespace App\Http\Controllers;

use App\Models\Tmbangunan;
use Illuminate\Http\Request;
use App\Models\Tmproyek;
use DataTables;
use Illuminate\Support\Facades\Auth;


class TmproyekController extends Controller
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
        $this->view    = '.tmproyek.';
        $this->route   = 'master.tmproyek.';
    }

    public function index()
    {
        $title = 'Data Master Proyek';
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
        $title = 'Tambah Proyek';
        return view($this->view . 'form_add', [
            'bangunan' => Tmbangunan::get(),
            'title' => $title
        ]);
    }
    public function api()
    {
        $data = Tmproyek::with(['User', 'Tmbangunan'])->get();
        return DataTables::of($data)
            ->editColumn('id', function ($p) {
                return "<input type='checkbox' name='cbox[]' value='" . $p->id . "' />";
            })
            ->editColumn('action', function ($p) {
                return  '<a href="" class="btn btn-warning btn-xs" id="edit" data-id="' . $p->id . '"><i class="fa fa-edit"></i>Edit </a> ';
            }, true)

            ->editColumn('namabangunan', function ($p) {
                return isset($p->Tmbangunan->nama_bangunan) ? $p->Tmbangunan->nama_bangunan : 'Kosong';
            }, true)

            ->editColumn('usercreate', function ($p) {
                return ($p->User->name) ? $p->User->name : 'Kosong';
            }, true)
            ->addIndexColumn()
            ->rawColumns(['usercreate', 'namabangunan', 'action', 'id'])
            ->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function getproyek()
    {
        $title = 'Master Data Bangunan';
        return view($this->view . 'select', compact('title'));
    }

    public function store()
    {
        $this->request->validate([
            'kode' => 'required|unique:tmproyek,kode',
            'nama_proyek' => 'required|unique:tmproyek,nama_proyek',
            'tgl_mulai' => 'required',
            'tgl_selesai' => 'required',

        ]);

        try {
            $data = new Tmproyek;
            $data->kode = $this->request->kode;
            $data->nama_proyek = $this->request->nama_proyek;
            $data->tgl_mulai = $this->request->tgl_mulai;
            $data->tgl_selesai = $this->request->tgl_selesai;
            $data->tmbangunan_id = $this->request->tmbangunan_id;
            $data->user_id = Auth::user()->id;
            $data->lokasi = $this->request->lokasi;

            $data->save();

            return response()->json([
                'status' => 1,
                'msg' => 'data berhasil di simpan',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 2,
                'msg' => 'gagal disimpan' . $th,
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
        $title = 'Edit Edit';
        $data = Tmproyek::findOrfail($id);
        // dd($data);
        return view($this->view . 'form_edit', [
            'title' => $title,
            'kode' => $data->kode,
            'nama_proyek' =>  $data->nama_proyek,
            'tgl_mulai' =>  $data->tgl_mulai,
            'bangunan' => Tmbangunan::get(),
            'lokasi' => $data->lokasi,
            'tgl_selesai' =>  $data->tgl_selesai,
            'tmbangunan_id' => $data->tmbangunan_id,
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
    public function update(Request $request, $id)
    {
        $this->request->validate([
            'tgl_mulai' => 'required',
            'tgl_selesai' => 'required'

        ]);
        try {
            $data      =  Tmproyek::find($id);
            $data->kode = $this->request->kode;
            $data->nama_proyek = $this->request->nama_proyek;
            $data->tgl_mulai = $this->request->tgl_mulai;
            $data->tgl_selesai = $this->request->tgl_selesai;
            $data->tmbangunan_id = $this->request->tmbangunan_id;
            $data->user_id = Auth::user()->id;
            $data->lokasi = $this->request->lokasi;
            $data->save();

            return response()->json([
                'status' => 1,
                'msg' => 'data berhasil di simpan',
            ]);
        } catch (\Tmproyek $th) {
            return response()->json([
                'status' => 1,
                'msg' => $th,
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
                    Tmproyek::whereIn('id', $this->request->id)->delete();
                else
                    Tmproyek::whereid($this->request->id)->delete();
                return response()->json([
                    'status' => 1,
                    'msg' => 'Data berhasil di hapus'
                ]);
            } catch (Tmproyek $t) {
                return response()->json([
                    'status' => 2,
                    'msg' => $t
                ]);
            }
        }
    }
}
