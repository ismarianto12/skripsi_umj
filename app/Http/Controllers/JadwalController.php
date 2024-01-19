<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use DataTables;
use Properti_app;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{

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
        $title = "Tambah Jadwal";
        $guru = DB::table("karyawan")->where('status', 1)->get();
        $kelas = DB::table("kelas")->get();
        $mapel = DB::table("mapel")->get();

        return view($this->view . "form_add", compact("title", "guru", 'kelas', 'mapel'));

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
            try {
                $request->validate([
                    'mapel_id' => 'required',
                    'kelas' => 'required',
                    'pertemuan' => 'required',
                    'jumlah_siswa' => 'required',
                ]);
            } catch (ValidationException $e) {
                return response()->json(['error' => $e->validator->errors()], 422);
            }

            $data = new Jadwal;
            $data->mapel_id = $this->request->mapel_id;
            $data->kelas_id = $this->request->kelas;
            $data->pertemuan = $this->request->pertemuan;
            $data->sesi = $this->request->sesi;
            $data->jumlah_siswa = $this->request->jumlah_siswa;
            $data->jam_mulai = $this->request->jam_mulai;
            $data->jam_selesai = $this->request->jam_selesai; 
            $data->hari = $this->request->hari; 
            $data->guru_id = $this->request->guru_id;
            $data->crated_at = $this->request->crated_at;
            $data->updated_at = $this->request->updated_at;
            $data->user_id = $this->request->user_id;
            $data->created_at = date('Y-m-d H:i:s');
            $data->tanggal = $this->request->tanggal;
            $data->save();
            return response()->json(['messages' => 'data berhasil disimpan'], 200);

        } catch (\Jadwal $th) {
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

    function jadwalscan()
    {
        $kelas = $this->request->data_kelas;
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
            $data->where('jadwal.kelas_id', '=', $kelas);
        }
        if ($guru) {
            $data->where('karyawan.guru_id', '=', $guru);
        }
        if (Auth::user()->level_id == '2') {
            $data->where('jadwal.guru_id', '=', Properti_app::guruid());

        }
        $sql = $data->get();
        return DataTables::of($sql)
            ->editColumn('id', function ($p) {
                return "<input type='checkbox' name='cbox[]' value='" . $p->id . "' />";
            })
            ->editColumn('action', function ($p) {
                return '<a href="' . Url('/master/scandetail/' . $p->id) . '" class="btn btn-warning btn-xs"><i class="fa fa-file"></i>Scan </a> <br />';
            }, true)

            ->addIndexColumn()
            ->rawColumns(['usercreate', 'action', 'id'])
            ->toJson();



    }
    function edit($id)
    {

        $title = "Edit jadwal";
        $data = Jadwal::findOrfail($id);
        $guru = DB::table("karyawan")->where('status', 1)->get();
        $kelas = DB::table("kelas")->get();
        $mapel = DB::table("mapel")->get();
        return view($this->view . "form_edit", compact("title", "guru", 'kelas', 'mapel', 'data'));

    }
    public function update($id)
    {
        try {
            try {
                $this->request->validate([
                    'mapel_id' => 'required',
                    'kelas' => 'required',
                    'pertemuan' => 'required',
                    'jumlah_siswa' => 'required',
                ]);
            } catch (ValidationException $e) {
            return response()->json(['error' => $e->validator->errors()], 422);
            }
            $data = Jadwal::findOrFail($id);
            $data->mapel_id = $this->request->mapel_id;
            $data->kelas_id = $this->request->kelas_id;
            $data->pertemuan = $this->request->pertemuan;
            $data->sesi = $this->request->sesi;
            $data->jumlah_siswa = $this->request->jumlah_siswa;
            $data->jam_mulai = $this->request->jam_mulai;
            $data->jam_selesai = $this->request->jam_selesai;             
            $data->hari = $this->request->hari;  
            $data->guru_id = $this->request->guru_id;
            $data->crated_at = $this->request->crated_at;
            $data->updated_at = $this->request->updated_at;
            $data->user_id = $this->request->user_id;
            $data->created_at = date('Y-m-d H:i:s');
        $data->tanggal = $this->request->tanggal;
            $data->save();
            return response()->json(['messages' => 'data berhasil disimpan'], 200);

        } catch (\Jadwal $th) {
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

    public function api()
    {

        $guru_id = Properti_app::guruid();
        $level = Auth::user()->level_id;


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
                'jadwal.hari', 
                'jadwal.crated_at',
                'jadwal.tanggal', 
                'jadwal.jam_mulai',
                'jadwal.jam_selesai', 
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
            ->join('kelas', 'jadwal.kelas_id', '=', 'kelas.kelas', 'left')
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
        if (Auth::user()->level_id == '2') {
            $data->where('jadwal.guru_id', '=', Properti_app::guruid());

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
            $data = Jadwal::whereIn('id', $this->request->id)->delete();
            return response()->json(['messages' => 'data berhasil hapus'], 200);
        } catch (\Throwable $th) {
            return response()->json(['messages' => $th->getMessage()], 500);
        }
    }

    
}
