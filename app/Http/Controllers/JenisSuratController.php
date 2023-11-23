<?php

namespace App\Http\Controllers;

use App\Models\Jenis_surat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;

class JenisSuratController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct(Request $request)
    {
        $this->request = $request;
        $this->view    = '.jenis_surat.';
        $this->route   = 'master.jenis_surat.';
    }

    public function index()
    {
        $title = 'Master Data Jenis_surat';
        return view($this->view . 'index', compact('title'));
    }


    protected function properti($d)
    {
        return [
            $kode = $this->request->kode,
            $jenis = $this->request->jenis,
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tanggal = Carbon::now()->format('Y-m-d');
        $title = 'Buat Data Jenis_surat';
        return view($this->view . 'form_add', [
            'title' => $title,
            'tanggal'=> $tanggal
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        try {
            $d = new Jenis_surat;
            $this->properti($d);
            $d->save();

            return response()->json([
                'status' => 1,
                'msg' => 'data berhasil dtambah'
            ]);
        } catch (Jenis_surat $t) {
            return response()->json([
                'status' => 1,
                'msg' =>  $t,
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jenis_surat  $Jenis_surat
     * @return \Illuminate\Http\Response
     */
    public function show(Jenis_surat $Jenis_surat)
    {
    }

    public function api(Jenis_surat $Jenis_surat)
    {
        $data = Jenis_surat::get();
        return DataTables::of($data)
            ->editColumn('id', function ($p) {
                return "<input type='checkbox' name='cbox[]' value='" . $p->id . "' />";
            })
            ->editColumn('action', function ($p) {
                return  '<a href="" class="btn btn-warning btn-xs" id="edit" data-id="' . $p->id . '"><i class="fa fa-edit"></i>Edit </a> ';
            }, true)
            ->addIndexColumn()
            ->rawColumns(['usercreate', 'proyek_name', 'action', 'id'])
            ->toJson();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Jenis_surat  $Jenis_surat
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Master Data Jenis surat';
        $d = Jenis_surat::find($id);

        return view($this->view . 'form_edit', [
            'id'          => $this->id,
            'kode'        => $this->kode,
            'jenis'       => $this->jenis,
            'user_id'     => $this->user_id,
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Jenis_surat  $Jenis_surat
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        // $this->request->validate([
        //     'jenis_Jenis_surat_id' => 'required',
        //     'site_id' => 'required',
        //     'site_name' => 'required',
        //     'nomor_pks' => 'required',
        //     'alamat_site' => 'required',
        //     'pic_pemilik_lahan' => 'required',
        //     'nilai_sewa_tahun' => 'required',
        //     'periode_sewa_awal' => 'required',
        //     'periode_sewa_akhir' => 'required',
        //     'nama_negosiator' => 'required',
        //     'email_negosiator' => 'required',
        //     'nomor_hp_negosiator' => 'required',
        //     'revenue_3_bulan' => 'required',
        //     'revenue_2_bulan' => 'required',
        //     'revenue_1_bulan' => 'required',
        //     'harga_patokan' => 'required',

        // ]);
        try {
            $d = Jenis_surat::find($id);
            $this->properti($d);
            $d->save();
            return response()->json([
                'status' => 1,
                'msg' => 'data berhasil dtambah'
            ]);
        } catch (\Tmlevel $t) {
            return response()->json([
                'status' => 1,
                'msg' =>  $t,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jenis_surat  $Jenis_surat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jenis_surat $Jenis_surat)
    {
        try {
            if (is_array($this->request->id))
                $Jenis_surat::whereIn('id', $this->request->id)->delete();
            else
                $Jenis_surat::whereid($this->request->id)->delete();
            return response()->json([
                'status' => 1,
                'msg' => 'Data berhasil di hapus'
            ]);
        } catch (Jenis_surat $t) {
            return response()->json([
                'status' => 2,
                'msg' => $t
            ]);
        }
    }
}
