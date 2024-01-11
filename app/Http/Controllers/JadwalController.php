<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use DataTables;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct(Request $request)
    {
        $this->request = $request;
        $this->view = '.jadwal.';
        $this->route = 'jadwal.';

    }
    public function index()
    {
        $title = "Master Data Jadwal";
        $guru = DB::table("karyawan")->where('status', 1)->get();
        $kelas = DB::table("kelas")->get();

        return view($this->view . "index", compact("title", "guru", 'kelas'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {


            $data = new Jadwal;
            $data->mapel_id = $this->request->mapel_id;
            $data->kelas_id = $this->request->kelas_id;
            $data->pertemuan = $this->request->pertemuan;
            $data->sesi = $this->request->sesi;
            $data->jumlah_siswa = $this->request->jumlah_siswa;
            $data->guru_id = $this->request->guru_id;
            $data->crated_at = $this->request->crated_at;
            $data->updated_at = $this->request->updated_at;
            $data->user_id = $this->request->user_id;
            $data->created_at = $this->request->created_at;
            $data->save();
            return response()->json(['messages' => 'data berhasil disimpan'], 200);

        } catch (\Throwable $th) {
            return response()->json(['messages' => $th->getMessage()], 500);
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
        try {


            $data = Jadwal::findOrFail($id);

            $data->mapel_id = $this->request->mapel_id;
            $data->kelas_id = $this->request->kelas_id;
            $data->pertemuan = $this->request->pertemuan;
            $data->sesi = $this->request->sesi;
            $data->jumlah_siswa = $this->request->jumlah_siswa;
            $data->guru_id = $this->request->guru_id;
            $data->crated_at = $this->request->crated_at;
            $data->updated_at = $this->request->updated_at;
            $data->user_id = $this->request->user_id;
            $data->created_at = $this->request->created_at;
            $data->save();
            return response()->json(['messages' => 'data berhasil disimpan'], 200);

        } catch (\Throwable $th) {
            return response()->json(['messages' => $th->getMessage()], 500);
        }
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
        //
    }
    public function api()
    {
        $kelas = $this->request->kelas_id;
        $guru = $this->request->guru;

        $data = DB::table('jadwal')
            ->select(
                'jadwal.id',
                'jadwal.mapel_id',
                'jadwal.kelas_id',
                'jadwal.pertemuan',
                'jadwal.sesi',
                'jadwal.jumlah_siswa',
                'jadwal.guru_id',
                'jadwal.crated_at',
                'jadwal.updated_at',
                'jadwal.user_id',
                'jadwal.created_at',
                'kelas.kelas',
                'kelas.tingkat',
                'karyawan.nama as guru_pengampu',
                'users.name',
                'mapel.nama_mapel',
                'mapel.kode'
            )
            ->join('kelas', 'jadwal.kelas_id', '=', 'kelas.id', 'left')
            ->join('karyawan', 'jadwal.guru_id', '=', 'karyawan.id', 'left')
            ->join('mapel', 'mapel.id', '=', 'jadwal.mapel_id', 'left')
            ->join('users', 'jadwal.user_id', '=', 'users.id', 'left')
            ->groupBy('jadwal.id');
        if ($kelas) {
            $data->where('kelas.id', '=', $kelas);
        }
        if ($guru) {
            $data->where('karyawan.guru_id', '=', $guru);
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
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data = Jadwal::findOrFail($id);
            $data->delet();
            return response()->json(['messages' => 'data berhasil hapus'], 200);
        } catch (\Throwable $th) {
            return response()->json(['messages' => $th->getMessage()], 500);
        }
    }
}
