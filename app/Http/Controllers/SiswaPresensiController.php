<?php

namespace App\Http\Controllers;

use App\Models\Guru;
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
        $title = 'Master Absensi Siswa';
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

        $title = 'Laporan Presensi Siswa';
        return view($this->view . 'laporan_persensi', compact('title'));

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
    public function edit($id)
    {

        if (!$this->request->ajax()) {
            return response()->json([
                'data' => 'data null',
                'aspx' => 'response aspx fail ',
            ]);
        }
        // $data = Guru::findOrfail($id);

        return 'QRI';

        // return view($this->view . 'form_edit', [
        //     'kode_rap' => $data->kode_rap,
        //     'nama_rap' => $data->nama_rap,
        //     'id' => $data->id,
        // ]);
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
    public function destroy($id)
    {
        try {
            if (is_array($this->request->id)) {
                Guru::whereIn('id', $this->request->id)->delete();
            } else {
                Guru::whereid($this->request->id)->delete();
            }

            return response()->json([
                'status' => 1,
                'msg' => 'Data berhasil di hapus',
            ]);
        } catch (Guru $t) {
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

}
