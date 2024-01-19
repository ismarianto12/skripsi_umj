<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\Presensi;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use PDF;

class SiswaPresensiController extends Controller
{
    protected $request;
    protected $route;
    protected $view;
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->view = '.absensiswa.';
        $this->route = 'master.absensiswa.';
    }

    public function index()
    {
        $kelas = DB::table('kelas')->get();
        $title = 'Laporan Absensi Siswa';
        return view($this->view . 'index', [
            'kelas' => $kelas,
            'title' => $title,
        ]);
    }
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
        $kelas_id = $this->request->kelas_id;
        $sql = DB::table('siswa')
            ->select(
                'siswa.id',
                'siswa.point',
                'siswa.nik',
                'siswa.nis',
                'siswa.nama',
                'siswa.email',
                'siswa.no_hp',
                'siswa.password',
                'siswa.jk',
                'siswa.ttl',
                'siswa.prov',
                'siswa.kab',
                'siswa.alamat',
                'siswa.nama_ayah',
                'siswa.nama_ibu',
                'siswa.pek_ayah',
                'siswa.pek_ibu',
                'siswa.nama_wali',
                'siswa.pek_wali',
                'siswa.peng_ortu',
                'siswa.no_telp',
                'siswa.thn_msk',
                'siswa.sekolah_asal',
                'siswa.kelas',
                'siswa.img_siswa',
                'siswa.img_kk',
                'siswa.img_ijazah',
                'siswa.img_ktp',
                'siswa.id_pend',
                'siswa.id_majors',
                'siswa.id_kelas',
                'siswa.status',
                'siswa.date_created',
                'siswa.role_id',
                'siswa.kelas_id',
                'siswa.tingkat_id',
                'siswa.ppdb_id',

            );

        if (!empty($kelas_id)) {
            $sql->where('siswa.kelas', $kelas_id);
        }
        $data = $sql->get();
        return DataTables::of($data)
            ->editColumn('id', function ($p) {
                return "<input type='checkbox' name='cbox[]' value='" . $p->id . "' />";
            })
            ->editColumn('action', function ($p) {
                return '<a href="" class="btn btn-warning btn-xs" id="qris" data-id="' . $p->id . '"><i class="fa fa-qris"></i>Qris </a> ';

            }, true)

            ->addIndexColumn()
            ->rawColumns(['action', 'id'])
            ->toJson();
    }

    public function store()
    {
        $this->request->validate([
            'kode_rap' => 'unique:Guru,kode_rap|required',
            'nama_rap' => 'unique:Guru,nama_rap|required',
        ]);
        try {
            $data = new Guru();
            $data->kode_rap = $this->request->kode_rap;
            $data->nama_rap = $this->request->nama_rap;
            $data->user_id = Auth::user()->id;
            $data->save();
            return response()->json([
                'status' => 1,
                'msg' => 'data jenis Rap berhasil ditambah',
            ]);
        } catch (\Guru $t) {
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
    public function laporanPresensi()
    {
        $kelas = DB::table('kelas')->get();
        $title = 'Laporan Presensi Siswa';
        return view($this->view . 'laporan_presensi', ['title' => $title, 'kelas' => $kelas]);

    }

    function edit($id)
    {
        $data = DB::table('presensi')
            ->select(
                'presensi.id as id_presensi',
                'presensi.id_siswa',
                'presensi.jadwal_id',
                'presensi.jam',
                'presensi.status as status_hadir',
                'presensi.created_at',
                'presensi.updated_at',
                'presensi.user_id',
                'presensi.pertemuan',
                'presensi.kelas_id',
                'presensi.mapel_id',
                'presensi.guru_id',
                'siswa.jk',
                'siswa.nik',
                'siswa.nama as siswa_nama'
            )
            ->where('presensi.id', $id)
            ->join('siswa', 'siswa.id', '=', 'presensi.id_siswa', 'left')
            ->first();
        $title = 'Edit Laporan Presensi Siswa';
        return view($this->view . 'laporan_presensi_edit', compact('data', 'title', 'id'));
    }
    function presensi_update($id)
    {
        try {
            \DB::table('presensi')->where('id', $id)->update([
                'status' => $this->request->status,
                'updated_at' => Auth::user()->id,
            ]);
            return response()->json([
                'messages' => 'data berhasil di simpan'
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'messages' => $th->getMessage()
            ]);

        }
    }

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

    public function update($id)
    {
        $data = $this->request->validate([
            'kode_rap' => 'required',
            'nama_rap' => 'required',
        ]);
        try {
            $data = new Guru();
            $data->find($id)->update($this->request->all());

            return response()->json([
                'status' => 1,
                'msg' => 'data jenis Rap berhasil ditambah',
            ]);
        } catch (\Guru $t) {
            return response()->json([
                'status' => 2,
                'msg' => $t,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        try {
            if (is_array($this->request->id)) {
                Presensi::whereIn('id', $this->request->id)->delete();
            } else {
                Presensi::whereid($this->request->id)->delete();
            }

            return response()->json([
                'status' => 1,
                'msg' => 'Data berhasil di hapus',
            ]);
        } catch (\Presensi $t) {
            return response()->json([
                'status' => 2,
                'msg' => $t,
            ]);
        }
    }
    public function mapeldata(Request $request)
    {
        $kelas_id = $request->kelas_id;
        $data = DB::table("mapel")->get();
        return response()->json($data);
    }


    function cetakpresensi()
    {
        $kelas_id = $this->request->kelas_id;
        $siswa = DB::table('siswa')->where('kelas', $kelas_id)->get();
        return view('absensiswa.cetak_presensi', [
            'url' => Url('/master/setAbsen'),
            'siswa' => $siswa,
        ]);

    }
    function scan()
    {
        $kelas = DB::table('kelas')->get();
        return view('absensiswa.scan', ['title' => '', 'kelas' => $kelas]);
    }



    function scandetail($id)
    {
        $kelas = DB::table('kelas')->get();
        $jadwal = Jadwal::getDatajadwal($id);
        return view('absensiswa.scandetail', ['title' => '', 'kelas' => $kelas, 'jadwal' => $jadwal]);

    }

    function laporan_presensi()
    {
        $kelas = DB::table('kelas')->get();
        return view($this->view . 'laporan_presensi', [
            'title' => 'Laporan Presensi',
            'kelas' => $kelas,
        ]);

    }

}
