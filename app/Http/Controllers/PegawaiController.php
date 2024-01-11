<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PegawaiController extends Controller
{
    protected $request;
    protected $route;
    protected $view;
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->view = '.pegawai.';
        $this->route = 'master.pegawai.';
    }

    public function index()
    {
        $title = 'Master Data Pegawai';
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
        $data = Pegawai::with('user')->get();
        return DataTables::of($data)
            ->editColumn('id', function ($p) {
                return "<input type='checkbox' name='cbox[]' value='" . $p->id . "' />";
            })
            ->editColumn('action', function ($p) {
                return '<a href="" class="btn btn-warning btn-xs" id="edit" data-id="' . $p->id . '"><i class="fa fa-edit"></i>Edit </a> ';

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
    public function store(Request $request)
    {
        try {
            $request->validate([
                'id_fingerprint' => 'required|string|max:250',
                'nik' => 'required|integer',
                'nama' => 'nullable|string|max:255',
                'jk' => 'required|in:L,P',
                'ttl' => 'required|date',
                'email' => 'nullable|email|max:255',
                'password' => 'nullable|string|max:255',
                'alamat' => 'required|string|max:255',
                'telp' => 'required|string|max:13',
                'id_divisi' => 'required|integer',
                'dept' => 'required|string|max:250',
                'intensif' => 'required|integer',
                'jam_mengajar' => 'required|integer',
                'nominal_jam' => 'required|integer',
                'bpjs' => 'required|integer',
                'koperasi' => 'required|integer',
                'simpanan' => 'required|integer',
                'tabungan' => 'required|integer',
                'id_pend' => 'required|integer',
                'kode_reff' => 'nullable|string|max:255',
                'jumlah_reff' => 'required|integer',
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
            'ttl' => $request->input('ttl'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'alamat' => $request->input('alamat'),
            'telp' => $request->input('telp'),
            'id_divisi' => $request->input('id_divisi'),
            'dept' => $request->input('dept'),
            'intensif' => $request->input('intensif'),
            'jam_mengajar' => $request->input('jam_mengajar'),
            'nominal_jam' => $request->input('nominal_jam'),
            'bpjs' => $request->input('bpjs'),
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
        $data = Pegawai::findOrfail($id);
        return view($this->view . 'form_edit', [
            'kode_rap' => $data->kode_rap,
            'nama_rap' => $data->nama_rap,
            'id' => $data->id,
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
        $data = $this->request->validate([
            'kode_rap' => 'required',
            'nama_rap' => 'required',
        ]);
        try {
            $data = new Pegawai();
            $data->find($id)->update($this->request->all());

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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
    function laporan_pegawai()
    {
        $bidang = [
            1 => 'Tenaga Pendidik',
            2 => 'Tengaga Kependidikan'
        ];
        return view($this->view . 'laporan', [
            'title' => 'Laporan Pegawai',
            'bidang' => $bidang,

        ]);
    }
}
