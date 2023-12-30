<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Guru;
use DataTables;

class GuruController extends Controller
{
    protected $request;
    protected $route;
    protected $view;
    function __construct(Request $request)
    {
        $this->request = $request;
        $this->view    = '.guru.';
        $this->route   = 'master.guru.';
    }


    public function index()
    {
        $title = 'Master Data Guru';
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
        $title = 'Master Data Jenis Rap';
        return view($this->view . 'select', compact('title'));
    }

    public function api()
    {
        $data = Guru::with('user')->get();
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
            'kode_rap' => 'unique:Guru,kode_rap|required',
            'nama_rap' => 'unique:Guru,nama_rap|required'
        ]);
        try {
            $data = new Guru();
            $data->kode_rap = $this->request->kode_rap;
            $data->nama_rap = $this->request->nama_rap;
            $data->user_id = Auth::user()->id;
            $data->save();
            return response()->json([
                'status' => 1,
                'msg' => 'data jenis Rap berhasil ditambah'
            ]);
        } catch (\Guru $t) {
            return response()->json([
                'status' => 2,
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
        $data = Guru::findOrfail($id);
        return view($this->view . 'form_edit', [
            'kode_rap' => $data->kode_rap,
            'nama_rap' => $data->nama_rap,
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
        $data =  $this->request->validate([
            'kode_rap' => 'required',
            'nama_rap' => 'required'
        ]);
        try {
            $data = new Guru();
            $data->find($id)->update($this->request->all());

            return response()->json([
                'status' => 1,
                'msg' => 'data jenis Rap berhasil ditambah'
            ]);
        } catch (\Guru $t) {
            return response()->json([
                'status' => 2,
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
        try {
            if (is_array($this->request->id))
                Guru::whereIn('id', $this->request->id)->delete();
            else
                Guru::whereid($this->request->id)->delete();
            return response()->json([
                'status' => 1,
                'msg' => 'Data berhasil di hapus'
            ]);
        } catch (Guru $t) {
            return response()->json([
                'status' => 2,
                'msg' => $t
            ]);
        }
    }
}
