<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Mapel;

class MapelController extends Controller
{
    protected $request;
    protected $route;
    protected $view;
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->view = '.mapel.';
        $this->route = 'master.mapel.';
    }

    public function index()
    {
        $title = 'Master Data Pelajaran';
        $kelas = DB::table('kelas')->get();
        return view($this->view . 'index', compact('title', 'kelas'));
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

    public function

        api(
    ) {

        $kelas = $this->request->kelas_id;
        $data = DB::table('mapel')
            ->select(
                'mapel.id',
                'mapel.unit_id',
                'mapel.kelas_id',
                'mapel.kode',
                'mapel.nama_mapel',
                'mapel.created_at',
                'mapel.updated_at',
                'mapel.user_id',
                'mapel.nama_mapel',
                'mapel.kkm',
                'kelas.kelas',
                'kelas.tingkat'
            )
            ->join('kelas', 'mapel.kelas_id', '=', 'kelas.id', 'left')
            ->join('users', 'mapel.user_id', '=', 'users.id', 'left');
        if ($kelas) {
            $data->where('kelas.id', '=', $kelas);
        }
        $data->get();
        return DataTables::of($data)
            ->editColumn('id', function ($p) {
                return "<input type='checkbox' name='cbox[]' value='" . $p->id . "' />";
            })
            ->editColumn('action', function ($p) {
                return '<a href="" class="btn btn-warning btn-xs" id="edit" data-id="' . $p->id . '"><i class="fa fa-list"></i>Detail </a> ';

            }, true)

            ->addIndexColumn()
            ->rawColumns(['usercreate', 'action', 'id'])
            ->toJson();
    }

    public function store()
    {
        $this->request->validate([
            'kode' => 'required',
            'nama_mapel' => 'required',
            'kkm' => 'required'
        ]);
        try {
            $data = new Pegawai();

            $data->kode_rap = $this->request->kode_rap;
            $data->nama_rap = $this->request->nama_rap;
            $data->user_id = Auth::user()->id;

            $data->save();
            return response()->json([
                'status' => 1,
                'msg' => 'data jenis Rap berhasil ditambah',
            ]);
        } catch (\Pegawai $t) {
            return response()->json([
                'status' => 2,
                'msg' => $t,
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
                'aspx' => 'response aspx fail ',
            ]);
        }
        $data = Mapel::findOrfail($id);
        $kelas = \DB::table('kelas')->get();
        return view($this->view . 'form_edit', [
            'kelas' => $kelas,
            'data' => $data,
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
            'kode' => 'required',
            'nama_mapel' => 'required',
            'kkm' => 'required'
        ]);
        try {
            $data = new Mapel();
            $data->find($id)->update($this->request->all());
            return response()->json([
                'status' => 1,
                'msg' => 'data jenis Rap berhasil ditambah',
            ]);
        } catch (\Mapel $t) {
            return response()->json([
                'status' => 2,
                'msg' => $t,
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            if (is_array($this->request->id)) {
                Pegawai::whereIn('id', $this->request->id)->delete();
            } else {
                Pegawai::whereid($this->request->id)->delete();
            }

            return response()->json([
                'status' => 1,
                'msg' => 'Data berhasil di hapus',
            ]);
        } catch (Pegawai $t) {
            return response()->json([
                'status' => 2,
                'msg' => $t,
            ]);
        }
    }
}
