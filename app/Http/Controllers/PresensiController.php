<?php

namespace App\Http\Controllers;

use DataTables;

use App\Models\Presensi;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\Jadwal;

class PresensiController extends Controller
{
    function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {

    }
    function api()
    {

        $kelas = $this->request->kelas_id;
        $mape_id = $this->request->mapel_id;
        $dari = $this->request->dari;
        $sampai = $this->request->sampai;

        $data = DB::table('presensi')
            ->select(
                'presensi.id_siswa',
                'presensi.jadwal_id',
                'presensi.jam',
                'presensi.status as status_hadir',
                'presensi.created_at',
                'presensi.updated_at',
                'presensi.user_id',
                'presensi.pertemuan',
                'presensi.guru_id',
                'presensi.kelas_id',
                'presensi.mapel_id',
                'presensi.guru_id',
                'mapel.nama_mapel',
                'jadwal.id',
                'karyawan.nama as guru_pengampu',
                'siswa.jk',
                'siswa.nik',
                'siswa.nama'
            )
            ->join('karyawan', 'karyawan.id', '=', 'presensi.guru_id', 'left')
            ->join('siswa', 'siswa.id', '=', 'presensi.siswa_id', 'left')
            ->join('mapel', 'mapel.id', '=', 'presensi.mapel_id', 'left')
            ->join('kelas', 'presensi.kelas_id', '=', 'kelas.id', 'left')
            ->join('jadwal', 'jadwal.id', '=', 'presensi.jadwal_id', 'left')
            ->get();

        return DataTables::of($data)
            ->editColumn('id', function ($p) {
                return "<input type='checkbox' name='cbox[]' value='" . $p->id . "' />";
            })
            ->editColumn('action', function ($p) {
                return '<a href="" class="btn btn-warning btn-xs" id="edit" data-id="' . $p->id . '"><i class="fa fa-list"></i>Ubah Presensi </a> ';

            }, true)

            ->addIndexColumn()
            ->rawColumns(['usercreate', 'action', 'id'])
            ->toJson();
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

    public function setJadwal()
    {
        try {

            $pertemuan = $this->request->pertemuan;
            $check = DB::table('presensi')->where('pertemuan', $pertemuan)->get();
            if ($check->count() > 0) {
                return response()->json([
                    "error" => 'gagal pertemnuan sudah ada sebelumnya'
                ], 400);
            } else {

                $data = new Jadwal();
                $data->mapel_id = $this->request->mapel_id;
                $data->kelas_id = $this->request->kelas_id;
                $data->pertemuan = $pertemuan;
                $data->sesi = $this->request->sesi ? $this->request->sesi : '';
                $data->jumlah_siswa = $this->request->jumlah_siswa;

                $data->created_at = date('Y-m-d');
                $data->updated_at = date('Y-m-d');

                $data->user_id = $this->request->user_id;
                $data->save();

                return response()->json([
                    'msg' => 'data berhasil di simpan'
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'msg' => $th->getMessage()
            ], 400);
        }
    }


    public function saveabsen(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $jam_sekarang = date('H:i:s');
        $jadwal_id = $request->jadwal_id;
        try {
            $pertemuan = $this->request->pertemuan;
            $check = DB::table('presensi')->where(['pertemuan' => $pertemuan, 'id_siswa' => $this->request->id_siswa])->get();
            if ($check->count() > 0) {
                return response()->json([
                    "error" => 'gagal presensi sudah ada sebelumnya'
                ], 400);
            } else {
                $nowdata = date('Y-m-d');
                $data = new Presensi;
                $data->id_siswa = $this->request->id_siswa;
                $data->jadwal_id = $this->request->jadwal_id;
                $data->pertemuan = $pertemuan;
                $data->jam = $jam_sekarang;
                $data->status = $this->request->status;
                $data->created_at = $nowdata;
                $data->updated_at = $nowdata;
                $data->guru_id = $this->request->guru_id;
                $data->pertemuan = $this->request->pertemuan;
                $data->user_id = $this->request->user_id;
                $data->guru_id = $this->request->user_id;

                $data->save();
                return response()->json(['msg' => 'data berhasil disimpan']);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "error" => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Presensi  $presensi
     * @return \Illuminate\Http\Response
     */
    public function show(Presensi $presensi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Presensi  $presensi
     * @return \Illuminate\Http\Response
     */
    public function edit(Presensi $presensi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Presensi  $presensi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Presensi $presensi)
    {
        //
    }

    public function destroy(Presensi $presensi)
    {
        try {
            Presensi::destroy($presensi);
        } catch (\Presensi $th) {
            return response()->json(['msg' => $th->getMessage()]);
        }
    }
}