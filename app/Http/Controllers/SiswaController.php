<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Siswa;

class SiswaController extends Controller
{
    protected $request;
    protected $route;
    protected $view;
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->view = '.siswa.';
        $this->route = 'master.siswa.';
    }

    public function index()
    {
        $title = 'Master Data Siswa';
        $kelas = DB::table('kelas')->get();
        return view($this->view . 'index', compact('title', 'kelas'));
    }

    function laporan_siswa()
    {
        $title = 'Laporan Siswa';
        $kelas = DB::table('kelas')->get();
        return view($this->view . '.laporan_siswa', [
            'title' => $title,
            'kelas' => $kelas
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
        $kelas = $this->request->kelas_id;
        $dari = $this->request->fromDate;
        $sampai = $this->request->toDate;

        $data = DB::table('siswa')
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

        if ($kelas) {
            $data->where('siswa.kelas', $kelas);
        } else {
            $data->get();
        }
        if ($dari && $sampai) {
            $data->whereBetween('siswa.date_created', [$dari, $sampai]);
        }
        return DataTables::of($data)
            ->editColumn('id', function ($p) {
                return "<input type='checkbox' name='cbox[]' value='" . $p->id . "' />";
            })
            ->editColumn('action', function ($p) {
                return '<a href="" class="btn btn-warning btn-xs" id="edit" data-id="' . $p->id . '"><i class="fa fa-edit"></i>Edit </a> ';

            }, true)

            ->addIndexColumn()
            ->rawColumns(['action', 'id'])
            ->toJson();
    }

    public function store(Request $request)
    {

        try {

            try {
                $request->validate([

                    'nik' => 'required|integer',
                    'nama' => 'nullable|string|max:255',
                    'jk' => 'required|in:L,P',
                ]);
            } catch (ValidationException $e) {
                return response()->json(['error' => $e->validator->errors()], 422);
            }
            $data = new Siswa;
            $data->point = ($this->request->point) ? $this->request->point : 0;
            $data->nik = $this->request->nik;
            $data->nis = $this->request->nis;
            $data->nama = $this->request->nama;
            $data->email = $this->request->email;
            $data->no_hp = $this->request->no_hp;
            $data->password = $this->request->password;
            $data->jk = $this->request->jk;
            $data->ttl = $this->request->ttl;
            $data->prov = $this->request->provinsi;
            $data->kab = $this->request->kabupaten;
            $data->alamat = $this->request->alamat;
            $data->nama_ayah = $this->request->nama_ayah;
            $data->nama_ibu = $this->request->nama_ibu;
            $data->pek_ayah = $this->request->pek_ayah;
            $data->pek_ibu = $this->request->pek_ibu;
            $data->nama_wali = $this->request->nama_wali;
            $data->pek_wali = $this->request->pek_wali;
            $data->peng_ortu = $this->request->peng_ortu;
            $data->no_telp = $this->request->no_telp;
            $data->thn_msk = $this->request->thn_msk;
            $data->sekolah_asal = $this->request->sekolah_asal;
            $data->kelas = $this->request->kelas ? $this->request->kelas : 0;
            $data->img_siswa = $this->request->img_siswa ? $this->request->img_siswa : '';
            $data->img_kk = $this->request->img_kk ? $this->request->img_kk : '';
            $data->img_ijazah = $this->request->img_ijazah ? $this->request->img_ijazah : '';
            $data->img_ktp = $this->request->img_ktp ? $this->request->img_ktp : '';
            $data->id_pend = $this->request->pendidikan;
            $data->id_majors = $this->request->id_majors ? $this->request->id_majors : 0;
            $data->id_kelas = $this->request->id_kelas ? $this->request->id_kelas : 0;
            $data->status = $this->request->status ? $this->request->status : 1;
            $data->date_created = date('Y-m-d H:i:s');
            $data->role_id = 1;
            $data->kelas_id = $this->request->kelas_id ? $this->request->kelas_id : 0;
            $data->tingkat_id = $this->request->tingkat_id;
            $data->ppdb_id = $this->request->ppdb_id;
            $data->save();
            return response()->json([
                'msg' => 'data berhasil disimpan',
            ]);
        } catch (\siswa $th) {
            return response()->json([
                'msg' => $th->getMessage(),
            ], 400);

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

    public function edit($id)
    {

        if (!$this->request->ajax()) {
            return response()->json([
                'data' => 'data null',
                'aspx' => 'response aspx fail ',
            ]);
        }
        $data = Siswa::findOrfail($id);
        return view($this->view . 'form_edit', [
            'kode_rap' => $data->kode_rap,
            'nama_rap' => $data->nama_rap,
            'id' => $data->id,
            'data' => $data,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data = Siswa::find($id);
            $data->point = ($this->request->point) ? $this->request->point : 0;
            $data->nik = $this->request->nik;
            $data->nis = $this->request->nis;
            $data->nama = $this->request->nama;
            $data->email = $this->request->email;
            $data->no_hp = $this->request->no_hp;
            $data->password = $this->request->password;
            $data->jk = $this->request->jk;
            $data->ttl = $this->request->ttl;
            $data->prov = $this->request->provinsi;
            $data->kab = $this->request->kabupaten;
            $data->alamat = $this->request->alamat;
            $data->nama_ayah = $this->request->nama_ayah;
            $data->nama_ibu = $this->request->nama_ibu;
            $data->pek_ayah = $this->request->pek_ayah;
            $data->pek_ibu = $this->request->pek_ibu;
            $data->nama_wali = $this->request->nama_wali;
            $data->pek_wali = $this->request->pek_wali;
            $data->peng_ortu = $this->request->peng_ortu;
            $data->no_telp = $this->request->no_telp;
            $data->thn_msk = $this->request->thn_msk;
            $data->sekolah_asal = $this->request->sekolah_asal;
            $data->kelas = $this->request->datakelas ? $this->request->datakelas : 0;
            $data->img_siswa = $this->request->img_siswa ? $this->request->img_siswa : '';
            $data->img_kk = $this->request->img_kk ? $this->request->img_kk : '';
            $data->img_ijazah = $this->request->img_ijazah ? $this->request->img_ijazah : '';
            $data->img_ktp = $this->request->img_ktp ? $this->request->img_ktp : '';
            $data->id_pend = $this->request->pendidikan;
            $data->id_majors = $this->request->id_majors ? $this->request->id_majors : 0;
            $data->id_kelas = $this->request->id_kelas ? $this->request->id_kelas : 0;
            $data->status = $this->request->status ? $this->request->status : 1;
            $data->date_created = date('Y-m-d H:i:s');
            $data->role_id = 1;
            $data->kelas_id = $this->request->kelas_id ? $this->request->kelas_id : 0;
            $data->tingkat_id = $this->request->tingkat_id;
            $data->ppdb_id = $this->request->ppdb_id;
            $data->save();
            return response()->json([
                'msg' => 'data berhasil disimpan',
            ]);
        } catch (\siswa $th) {
            return response()->json([
                'msg' => $th->getMessage(),
            ], 400);

        }
    }

    public function destroy($id)
    {
        // Menghapus data siswa berdasarkan ID
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();
        return response()->json(null, 204);
    }

}
