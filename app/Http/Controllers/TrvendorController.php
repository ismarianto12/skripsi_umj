<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trvendor;
use DataTables;
use Illuminate\Support\Facades\Auth;

class TrvendorController extends Controller
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
        $this->view    = '.trvendor.';
        $this->route   = 'master.trvendor.';
    }


    public function index()
    {
        $title = 'Master Data Vendor / Pihak Ke tiga';
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
        $title = 'Master Data Vendor / Pihak Ke tiga';
        return view($this->view . 'select', compact('title'));
    }

    public function api()
    {
        $data = Trvendor::with('User')->get();
        return DataTables::of($data)
            ->editColumn('id', function ($p) {
                return "<input type='checkbox' name='cbox[]' value='" . $p->id . "' />";
            })
            ->editColumn('action', function ($p) {
                return  '<a href="" class="btn btn-warning btn-xs" id="edit" data-id="' . $p->id . '"><i class="fa fa-edit"></i>Edit </a> ';

            }, true)
            ->editColumn('name', function ($p) {
                return $p->name;
            }, true)
            ->addIndexColumn()
            ->rawColumns(['usercreate', 'action', 'id'])
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
            'kode' => 'required|unique:trvendor,kode',
            'nama' => 'required|unique:trvendor,nama',
            'npwp' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
            'email' => 'required',
        ]);
        try {
            $data = new Trvendor();
            $data->kode = $this->request->kode;
            $data->nama = $this->request->nama;
            $data->npwp = $this->request->npwp;
            $data->alamat = $this->request->alamat;
            $data->no_telp = $this->request->no_telp;
            $data->email = $this->request->email;
            $data->user_id = Auth::user()->id;
            $data->save();

            return response()->json([
                'status' => 1,
                'msg' => 'data vendor berhasil dtambah'
            ]);
        } catch (Trvendor $t) {
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
     'data'=>'data null',
     'aspx'=>'response aspx fail '
 ]);
}
        $r = Trvendor::findOrfail($id);
        return view($this->view . 'form_edit', [
            'kode' => $r->kode,
            'nama' => $r->nama,
            'npwp' => $r->npwp,
            'alamat' => $r->alamat,
            'no_telp' => $r->no_telp,
            'email' => $r->email,
            'id' => $id
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
            'kode' => 'required|unique:trvendor,kode',
            'nama' => 'required|unique:trvendor,nama',
            'npwp' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
            'email' => 'required'
        ]);
        try {
            $data = Trvendor::find($id);
            $data->kode = $this->request->kode;
            $data->nama = $this->request->nama;
            $data->npwp = $this->request->npwp;
            $data->alamat = $this->request->alamat;
            $data->no_telp = $this->request->no_telp;
            $data->email = $this->request->email;
            $data->user_id = Auth::user()->id;
            $data->save();

            return response()->json([
                'status' => 1,
                'msg' => 'data vendor berhasil dtambah'
            ]);
        } catch (Trvendor $t) {
            return response()->json([
                'status' => 1,
                'msg' =>  $t,
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
                    Trvendor::whereIn('id', $this->request->id)->delete();
                else
                    Trvendor::whereid($this->request->id)->delete();
                return response()->json([
                    'status' => 1,
                    'msg' => 'Data berhasil di hapus'
                ]);
            } catch (Trvendor $t) {
                return response()->json([
                    'status' => 2,
                    'msg' => $t
                ]);
            }
        }
    }
}
