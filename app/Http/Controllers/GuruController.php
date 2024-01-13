<?php

namespace App\Http\Controllers;

use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GuruController extends Controller
{
    protected $request;
    protected $route;
    protected $view;
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->view = '.guru.';
        $this->route = 'master.guru.';
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
        $data = DB::table('karyawan')
            ->select(
                'karyawan.id',
                'karyawan.id_fingerprint',
                'karyawan.nik',
                'karyawan.nama',
                'karyawan.jk',
                'karyawan.ttl',
                'karyawan.email',
                'karyawan.password',
                'karyawan.alamat',
                'karyawan.telp',
                'karyawan.id_divisi',
                'karyawan.dept',
                'karyawan.intensif',
                'karyawan.jam_mengajar',
                'karyawan.nominal_jam',
                'karyawan.bpjs',
                'karyawan.koperasi',
                'karyawan.simpanan',
                'karyawan.tabungan',
                'karyawan.id_pend',
                'karyawan.kode_reff',
                'karyawan.jumlah_reff',
                'karyawan.role_id',
                'karyawan.status',
                'karyawan.date_created',
                'karyawan.updated_at',
                'karyawan.created_at',
                'karyawan.user_id',
                'divisi.namadivisi'
            )
            ->join('divisi', 'karyawan.id_divisi', '=', 'divisi.id', 'left')
            ->get();
        return DataTables::of($data)
            ->editColumn('id', function ($p) {
                return "<input type='checkbox' name='cbox[]' value='" . $p->id . "' />";
            })
            ->editColumn('action', function ($p) {
                return '<a href="" class="btn btn-warning btn-xs" id="edit" data-id="' . $p->id . '"><i class="fa fa-edit"></i>Edit </a> ';

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
    public function store(Request $request)
    {
        try {
            $request->validate([
                'id_fingerprint' => 'required|string|max:250',
                'nik' => 'required|integer',
                'nama' => 'nullable|string|max:255',
                'jk' => 'required|in:L,P',
                // 'ttl' => 'required|date',
                'email' => 'nullable|email|max:255',

                'jam_mengajar' => 'required|integer',
                'nominal_jam' => 'required|integer',

                'koperasi' => 'required|integer',
                // 'simpanan' => 'required|integer',
                // 'tabungan' => 'required|integer',
                // 'id_pend' => 'required|integer',
                'kode_reff' => 'nullable|string|max:255',
                // 'jumlah_reff' => 'required|integer',
                'role_id' => 'nullable|integer',
                'status' => 'nullable|integer',
                'date_created' => 'nullable|date',
                'updated_at' => 'nullable|date',
                'created_at' => 'nullable|date',
                'user_id' => 'nullable|date',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->validator->errors()], 422);
        }
        DB::table('karyawan')->insert([
            'id_fingerprint' => $request->input('id_fingerprint'),
            'nik' => $request->input('nik'),
            'nama' => $request->input('nama'),
            'jk' => $request->input('jk'),
            'ttl' => $request->input('ttl') ? $request->input('ttl') : 'kosong',
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'alamat' => $request->input('alamat') ? $request->input('alamat') : 'kosong',
            'telp' => $request->input('telp') ? $request->input('telp') : 'kosong',
            'id_divisi' => $request->input('id_divisi') ? $request->input('id_divisi') : 'kosong',
            'dept' => $request->input('dept') ? $request->input('dept') : 'kosong',
            'intensif' => $request->input('intensif') ? $request->input('intensif') : 'kosong',
            'jam_mengajar' => $request->input('jam_mengajar'),
            'nominal_jam' => $request->input('nominal_jam'),
            'bpjs' => $request->input('bpjs') ? $request->input('bpjs') : 'kosong',
            'koperasi' => $request->input('koperasi'),
            'simpanan' => $request->input('simpanan'),
            'tempat_lahir' => $request->tempat_lahir,
            'tabungan' => $request->input('tabungan'),
            'id_pend' => $request->input('id_pend'),
            'kode_reff' => $request->input('kode_reff'),
            'jumlah_reff' => $request->input('jumlah_reff'),
            'role_id' => $request->input('role_id'),
            'status' => $request->input('status'),
            'date_created' => $request->input('date_created'),
            'updated_at' => $request->input('updated_at'),
            'created_at' => $request->input('created_at'),
            'user_id' => $request->input('user_id'),
        ]);
        return response()->json(['message' => 'Record inserted successfully'], 200);

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
        $data = DB::table('karyawan')->where('id', $id)->first();
        return view($this->view . 'form_edit', [
            'data' => $data,
            'id' => $id,
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
        try {
            $request->validate([
                'nama' => 'nullable|string|max:255',
                'jk' => 'required|in:L,P',
                'status' => 'nullable|integer',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->validator->errors()], 422);
        }
        DB::table('karyawan')->where('id', $id)->update([
            'nama' => $request->input('nama'),
            'jk' => $request->input('jk'),
            'ttl' => $request->input('ttl') ? $request->input('ttl') : 'kosong',
            'tempat_lahir' => $request->tempat_lahir,
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'alamat' => $request->input('alamat') ? $request->input('alamat') : 'kosong',
            'telp' => $request->input('telp') ? $request->input('telp') : 'kosong',
            'id_divisi' => $request->input('id_divisi') ? $request->input('id_divisi') : 'kosong',
            'dept' => $request->input('dept') ? $request->input('dept') : 'kosong',
            'intensif' => $request->input('intensif') ? $request->input('intensif') : 'kosong',
            'jam_mengajar' => $request->input('jam_mengajar'),
            'nominal_jam' => $request->input('nominal_jam'),
            'bpjs' => $request->input('bpjs') ? $request->input('bpjs') : 'kosong',
            'koperasi' => $request->input('koperasi'),
            'simpanan' => $request->input('simpanan'),
            'tabungan' => $request->input('tabungan'),
            'id_pend' => $request->input('id_pend'),
            'kode_reff' => $request->input('kode_reff'),
            'jumlah_reff' => $request->input('jumlah_reff'),
            'role_id' => $request->input('role_id'),
            'status' => $request->input('status'),
            'date_created' => $request->input('date_created'),
            'updated_at' => $request->input('updated_at'),
            'created_at' => $request->input('created_at'),
            'user_id' => Auth::user()->id,
        ]);
        return response()->json(['message' => 'Record inserted successfully'], 200);

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
                DB::table('karyawan')->whereIn('id', $this->request->id)->delete();
            } else {
                DB::table('karyawan')->whereid($this->request->id)->delete();
            }

            return response()->json([
                'status' => 1,
                'msg' => 'Data berhasil di hapus',
            ]);
        } catch (\DB $t) {
            return response()->json([
                'status' => 2,
                'msg' => $t,
            ]);
        }
    }
}
