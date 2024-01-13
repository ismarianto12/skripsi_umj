<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        $category = $this->request->category;
        $perPage = $this->request->page ? $this->request->page : 1;
        $query = Pegawai::join('divisi', 'divisi.id', '=', 'pegawai.id_divisi', 'left');
        if ($this->request->q) {
            $searchTerm = '%' . $this->request->q . '%';
            $query->where(function ($query) use ($searchTerm) {
                $query->where('pegawai.nama', 'LIKE', $searchTerm);
                $query->orWhere('pegawai.email', 'LIKE', $searchTerm);
            });
        }
        if ($this->request->sort) {
            if ($this->request->column == 'formatted_title') {
                $query->orderBy('pegawai.id', $this->request->sort);
            } else {
                $query->orderBy('pegawai.id_fingerprint', $this->request->sort);
            }
        }
        $posts = $query->paginate(7, ['*'], 'page', $perPage);
        return response()->json(['data' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        try {

            $data = Pegawai::find($id);
            $data->id_fingerprint = $request->id_fingerprint;
            $data->nik = $request->nik;
            $data->nama = $request->nama;
            $data->jk = $request->jk;
            $data->ttl = $request->ttl;
            $data->tempat_lahir = $request->tempat_lahir;
            $data->email = $request->email;
            $data->password = $request->password;
            $data->alamat = $request->alamat;
            $data->telp = $request->telp;
            $data->id_divisi = $request->id_divisi;
            $data->dept = $request->dept;
            $data->intensif = $request->intensif;
            $data->jam_mengajar = $request->jam_mengajar;
            $data->nominal_jam = $request->nominal_jam;
            $data->bpjs = $request->bpjs;
            $data->koperasi = $request->koperasi;
            $data->simpanan = $request->simpanan;
            $data->tabungan = $request->tabungan;
            $data->id_pend = $request->id_pend;
            $data->kode_reff = $request->kode_reff;
            $data->jumlah_reff = $request->jumlah_reff;
            $data->role_id = $request->role_id;
            $data->status = $request->status;
            $data->date_created = $request->date_created;
            $data->updated_at = $request->updated_at;
            $data->created_at = $request->created_at;
            $data->user_id = $request->user_id;
            $data->save();
            return response()->json([
                'data berhasil di simpan',
            ]);
        } catch (\Pegawai $th) {
            return response()->json([
                $th->getMessage(),
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function show(Pegawai $pegawai)
    {
        $data = $pegawai::find($id);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function edit(Pegawai $pegawai)
    {
        //
    }

    /**
     *
     *
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pegawai $pegawai, $id)
    {

        try {
            $data = new Pegawai;
            $data->id_fingerprint = $request->id_fingerprint;
            $data->nik = $request->nik;
            $data->nama = $request->nama;
            $data->jk = $request->jk;
            $data->ttl = $request->ttl;
            $data->tempat_lahir = $request->tempat_lahir;
            $data->email = $request->email;
            $data->password = $request->password;
            $data->alamat = $request->alamat;
            $data->telp = $request->telp;
            $data->id_divisi = $request->id_divisi;
            $data->dept = $request->dept;
            $data->intensif = $request->intensif;
            $data->jam_mengajar = $request->jam_mengajar;
            $data->nominal_jam = $request->nominal_jam;
            $data->bpjs = $request->bpjs;
            $data->koperasi = $request->koperasi;
            $data->simpanan = $request->simpanan;
            $data->tabungan = $request->tabungan;
            $data->id_pend = $request->id_pend;
            $data->kode_reff = $request->kode_reff;
            $data->jumlah_reff = $request->jumlah_reff;
            $data->role_id = $request->role_id;
            $data->status = $request->status;
            $data->date_created = $request->date_created;
            $data->updated_at = $request->updated_at;
            $data->created_at = $request->created_at;
            $data->user_id = $request->user_id;
            $data->save();
            return response()->json([
                'data berhasil di simpan',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                $th->getMessage(),
            ]);
        }

    }

    public function destroy(Pegawai $pegawai)
    {
        try {
            $data = $pegawai->find($id)->delete();
            return response()->json([
                'messages' => 'data berhasil di hapus.',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'messages' =>
                    'can\'t delete data ',
            ]);
        }
    }
}
