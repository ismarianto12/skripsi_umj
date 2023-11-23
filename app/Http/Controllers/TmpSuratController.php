<?php

namespace App\Http\Controllers;

use App\Models\tmp_surat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
class TmpSuratController extends Controller
{

    function __construct(Request $request)
    {
        date_default_timezone_set("Asia/Jakarta");
        $this->request = $request;
        $this->view    = '.tmpsurat.';
        $this->route   = 'master.tmpsurat.';
    }

    public function index()
    {
        $title = 'Parameter Biaya';
        return view($this->view . 'index', [
            'title' => $title,

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tanggal = Carbon::now()->format('y-m-d');
        return view($this->view . 'form_add', [
            'title' => '',
            'tanggal' => $tanggal
        ]);
    }

    public function api()
    {
        $data = tmp_surat::get();
        return DataTables::of($data)
            ->editColumn('id', function ($p) {
                return "<input type='checkbox' name='cbox[]' value='" . $p->id . "' />";
            })
            ->editColumn('action', function ($p) {
                return  '<a href="" class="btn btn-warning btn-xs" id="edit" data-id="' . $p->id . '"><i class="fa fa-edit"></i>Edit </a> ';;
            }, true)
            ->addIndexColumn()
            ->rawColumns(['action', 'id'])
            ->toJson();
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
            $d = new tmp_surat();
            $d->site_id = $this->request->site_id;
            $d->penawaran_th_1 = $this->request->penawaran_th_1;
            $d->penawaran_th_2 = $this->request->penawaran_th_2;
            $d->penawaran_th_3 = $this->request->penawaran_th_3;
            $d->penawaran_th_4 = $this->request->penawaran_th_4;
            $d->pemilik_1 = $this->request->pemilik_1;
            $d->pemilik_2 = $this->request->pemilik_2;
            $d->pemilik_3 = $this->request->pemilik_3;
            $d->pemilik_4 = $this->request->pemilik_4;
            $d->harga_sewa_baru = $this->request->harga_sewa_baru;
            $d->periode_awal =  $this->request->periode_sewa_baru_d;
            $d->periode_akhir =  $this->request->periode_sewa_baru_sd;
            $d->total_harga_sewa = $this->request->total_harga_sewa;
            $d->user_id = Auth::user()->id;
            $d->created_at  = Carbon::now()->format('Y-m-d');
            $d->updated_at = Carbon::now()->format('Y-m-d');


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
     * Display the specified resource.
     *
     * @param  \App\Models\tmp_surat  $tmp_surat
     * @return \Illuminate\Http\Response
     */
    public function show(tmp_surat $tmp_surat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tmp_surat  $tmp_surat
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = tmp_surat::find($id);
        return view($this->view . 'form_edit', [
            'title' => 'Edit data tmpsurat',
            'id' => $data->id,
            'penawaran_th_1' => $data->penawaran_th_1,
            'penawaran_th_2' => $data->penawaran_th_2,
            'penawaran_th_3' => $data->penawaran_th_3,
            'penawaran_th_4' => $data->penawaran_th_4,
            'pemilik_1' => $data->pemilik_1,
            'pemilik_2' => $data->pemilik_2,
            'pemilik_3' => $data->pemilik_3,
            'pemilik_4' => $data->pemilik_4,
            'harga_sewa_baru' => $data->harga_sewa_baru,
            'user_id' => $data->user_id,
            'updated_at' => $data->updated_at,
            'created_at' => $data->created_at,

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\tmp_surat  $tmp_surat
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        try {
            //code...
            $d = tmp_surat::find($id);
            $d->penawaran_th_1 = $this->request->penawaran_th_1;
            $d->penawaran_th_2 = $this->request->penawaran_th_2;
            $d->penawaran_th_3 = $this->request->penawaran_th_3;
            $d->penawaran_th_4 = $this->request->penawaran_th_4;
            $d->pemilik_1 = $this->request->pemilik_1;
            $d->pemilik_2 = $this->request->pemilik_2;
            $d->pemilik_3 = $this->request->pemilik_3;
            $d->pemilik_4 = $this->request->pemilik_4;
            $d->harga_sewa_baru = $this->request->harga_sewa_baru;
            $d->nama_pic = $this->request->nama_pic;
            $d->jabatan_pic = $this->request->jabatan_pic;
            $d->pengelola = $this->request->pengelola;
            $d->alamat_pic = $this->request->alamat_pic;
            $d->nomor_telepon_pic = $this->request->nomor_telepon_pic;

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
     * @param  \App\Models\tmp_surat  $tmp_surat
     * @return \Illuminate\Http\Response
     */
    public function destroy(tmp_surat $tmp_surat)
    {
        //
        try {
            if (is_array($this->request->id))
                $tmp_surat::whereIn('id', $this->request->id)->delete();
            else
                $tmp_surat::whereid($this->request->id)->delete();
            return response()->json([
                'status' => 1,
                'msg' => 'Data berhasil di hapus'
            ]);
        } catch (tmp_surat $t) {
            return response()->json([
                'status' => 2,
                'msg' => $t
            ]);
        }
    }
}
