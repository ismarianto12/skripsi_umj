<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tmprogres_spk;
use App\Models\Tmrspk;
use DataTables;
use Illuminate\Support\Facades\Auth;

class TmprogresSpkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $request;
    protected $route;
    protected $view;
    function __construct(Request $request)
    {
        $this->request = $request;
        $this->view    = '.tmprogresspk.';
        $this->route   = 'master.tmprogresspk.';
    }


    public function index()
    {
        $title = 'Master Progress Surat Perintah Kerja';
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

        $title = 'Pogress Surat Perintah Kerja.';
        return view($this->view . 'form_add', [
            'title' => $title,
            'tmrspk' => Tmrspk::join('tmrap', 'tmrap.id', '=', 'tmrspk.tmrap_id')
                ->join('tmproyek', 'tmproyek.id', '=', 'tmrap.tmproyek_id')
                ->select('tmrspk.no_spk', 'tmproyek.nama_proyek', 'tmrspk.id')->get()
        ]);
    }

    public function getbangunan()
    {
        $title = 'Master Progress Surat Perintah Kerja';
        return view($this->view . 'select', compact('title'));
    }

    public function api()
    {
        $data = Tmprogres_spk::with('User', 'Tmrspk')->get();
        return DataTables::of($data)
            ->editColumn('id', function ($p) {
                return "<input type='checkbox' name='cbox[]' value='" . $p->id . "' />";
            })
            ->editColumn('action', function ($p) {
                return  '<a href="" class="btn btn-warning btn-xs" id="edit" data-id="' . $p->id . '"><i class="fa fa-edit"></i>Edit </a> ';
            }, true)
            ->editColumn('usercreate', function ($p) {
                return isset($p->User->name) ? $p->User->name : 'Kosong';
            }, true)
            ->editColumn('nospk', function ($p) {
                return isset($p->Tmrspk->no_spk) ? $p->Tmrspk->no_spk : 'Kosong';
            }, true)
            ->addIndexColumn()
            ->rawColumns(['usercreate', 'nospk', 'action', 'id'])
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
        // dd($this->request);
        $this->request->validate([
            'tmrspk_id' => 'required',
            'periode_awal' => 'required',
            'periode_akhir' => 'required',
            'spk_progress_lalu' => 'required',
            'spk_progress_skg' => 'required',
            'spk_progress_tot' => 'required',
            'spk_harga_progres' => 'required',
            'spk_harga_sisa' => 'required'
        ]);
        try {
            $nilspk_lalu  = str_replace(',', '', $this->request->spk_progress_lalu);
            $lalu_spk     =  ($nilspk_lalu == 0) ?  $nilspk_lalu : $this->request->spk_progress_skg;

            $data = new Tmprogres_spk();
            $data->tmrspk_id = $this->request->tmrspk_id;
            $data->periode_awal = $this->request->periode_awal;
            $data->periode_akhir = $this->request->periode_akhir;
            $data->spk_progress_lalu =  $nilspk_lalu;
            $data->spk_progress_skg = str_replace(',', '', $this->request->spk_progress_skg);
            $data->spk_progress_tot =  str_replace(',', '', $this->request->spk_progress_tot);
            $data->spk_harga_progres =  str_replace(',', '', $this->request->spk_harga_progres);
            $data->spk_harga_sisa =  str_replace(',', '', $this->request->spk_harga_sisa);
            $data->user_id = Auth::user()->id;
            $data->save();

            return response()->json([
                'status' => 1,
                'msg' => 'data monitoring SPK berhasil ditambah'
            ]);
        } catch (\Tmprogres_spk $t) {
            return response()->json([
                'status' => 1,
                'msg' =>  $t,
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function searchpogres()
    {
        $level         = Auth::user()->levelid;
        $tmproyek_id   = Auth::user()->tmproyek_id;
        $tmprogress_id = $this->request->id; // tmprogress id 


        Tmprogres_spk::select(
            'tmprogres_spk.periode_awal',
            'tmprogres_spk.periode_akhir',
            'tmprogres_spk.spk_progress_lalu',
            'tmprogres_spk.spk_progress_skg',
            'tmprogres_spk.spk_progress_tot',
            'tmprogres_spk.spk_harga_progres',
            'tmprogres_spk.spk_harga_sisa',
            'tmrspk.tanggal',
            'tmrspk.pekerjaan',
            'tmproyek.nama_proyek',
            'tmproyek.tmbangunan_id',
            'tmproyek.kode'
        )
            ->join('tmrspk', 'tmprogres_spk.tmrspk_id', '=', 'tmrspk.id')
            ->join('tmrap', 'tmrspk.tmrap_id', '=', 'tmrap.id')
            ->join('trvendor', 'tmrspk.trvendor_id', '=', 'trvendor.id')
            ->join('tmproyek', 'tmrap.tmproyek_id', '=', 'tmproyek.id')
            ->first();
    }
    public function edit($id)
    {

        if (!$this->request->ajax()) {
            return response()->json([
                'data' => 'data null',
                'aspx' => 'response aspx fail '
            ]);
        }
        //
        $data = Tmprogres_spk::find($id);
        return view($this->view . 'form_edit', [
            'tmrspk' => Tmrspk::join('tmrap', 'tmrap.id', '=', 'tmrspk.tmrap_id')
                ->join('tmproyek', 'tmproyek.id', '=', 'tmrap.tmproyek_id')
                ->select('tmrspk.no_spk', 'tmproyek.nama_proyek', 'tmrspk.id')->get(),
            'tmrspk_id' => $data->tmrspk_id,
            'periode_awal' => $data->periode_awal,
            'periode_akhir' => $data->periode_akhir,
            'spk_progress_lalu' => $data->spk_progress_lalu,
            'spk_progress_skg' => $data->spk_progress_skg,
            'spk_progress_tot' => $data->spk_progress_tot,
            'spk_harga_progres' => $data->spk_harga_progres,
            'spk_harga_sisa' => $data->spk_harga_sisa,
            'id' => $data->id
        ]);
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
        // dd($this->request);
        $this->request->validate([
            'tmrspk_id' => 'required',
            'periode_awal' => 'required',
            'periode_akhir' => 'required',
            'spk_progress_lalu' => 'required',
            'spk_progress_skg' => 'required',
            'spk_progress_tot' => 'required',
            'spk_harga_progres' => 'required',
            'spk_harga_sisa' => 'required'
        ]);
        try {
            $nilspk_lalu             = str_replace(',', '', $this->request->spk_progress_lalu);
            $lalu_spk     =  ($nilspk_lalu == 0) ?  $nilspk_lalu : $this->request->spk_progress_skg;
            // if save update action data
            $data                    = Tmprogres_spk::find($id);
            $data->tmrspk_id         = $this->request->tmrspk_id;
            $data->periode_awal      = $this->request->periode_awal;
            $data->periode_akhir     = $this->request->periode_akhir;
            $data->spk_progress_lalu =  $nilspk_lalu;
            $data->spk_progress_skg  = str_replace(',', '', $this->request->spk_progress_skg);
            $data->spk_progress_tot  = str_replace(',', '', $this->request->spk_progress_tot);
            $data->spk_harga_progres = str_replace(',', '', $this->request->spk_harga_progres);
            $data->spk_harga_sisa    = str_replace(',', '', $this->request->spk_harga_sisa);
            $data->user_id           = Auth::user()->id;
            $data->save();

            return response()->json([
                'status' => 1,
                'msg' => 'Data monitoring SPK berhasil edit'
            ]);
        } catch (\Tmprogres_spk $t) {
            return response()->json([
                'status' => 1,
                'msg' =>  $t,
            ]);
        }
    }
    public function detail()
    {
        $id = $this->request->id;
        $data = Tmrspk::join('tmrap', 'tmrap.id', '=', 'tmrspk.tmrap_id')
            ->join('tmproyek', 'tmproyek.id', '=', 'tmrap.tmproyek_id')
            ->select('tmrspk.spk_jumlah_harga as nilai', 'tmrspk.no_spk', 'tmproyek.nama_proyek', 'tmrspk.id')
            ->find($id);

        $result = number_format($data->nilai, 2);
        return response()->json($result);
    }
    // get value percentage spk before with asc 
    public function getparentspk()
    {
        $tmrspk_id = $this->request->tmrspk_id;
        $data = Tmprogres_spk::where('tmrspk_id', $tmrspk_id)
            ->orderBy('tmprogres_spk.periode_awal', 'desc');

        if ($this->request->percentage == 'yes') {
            $rdata =  $data->select('spk_progress_lalu', 'spk_progress_skg', 'spk_progress_tot')->get();
            // dd($rdata);
            $datas = response()->json($rdata);
        } else {
            $fdata =  $data->select(
                \DB::raw('sum(spk_progress_lalu) as plalu'),
                \DB::raw('sum(spk_progress_skg) as pskg'),
                'tmprogres_spk.tmrspk_id',
                'tmprogres_spk.periode_awal',
                'tmprogres_spk.periode_akhir',
                'tmprogres_spk.spk_progress_lalu',
                'tmprogres_spk.spk_progress_skg',
                'tmprogres_spk.spk_progress_tot',
                'tmprogres_spk.spk_harga_progres',
                'tmprogres_spk.spk_harga_sisa'
            )
                ->first();
            $datas = response()->json($fdata);
        }
        return $datas;
    }

    public function getspkprogress()
    {
        $tmrspk_id = $this->request->tmrspk_id;
        $spk_progress_tot = $this->request->spk_progress_tot;

        $datas = Tmprogres_spk::select(
            'tmrspk.no_spk',
            'tmrspk.spk_harga_satuan',
            'tmrspk.spk_jumlah_harga',
            'tmrspk.satuan',
            
            'tmprogres_spk.periode_awal',
            'tmprogres_spk.periode_akhir',
            'tmprogres_spk.spk_progress_lalu',
            'tmprogres_spk.spk_progress_skg',
            'tmprogres_spk.spk_harga_progres',
            'tmprogres_spk.spk_progress_tot',
            'tmprogres_spk.spk_harga_sisa',
            'tmmonitoring_pembayaranspk.periode_awal',
            'tmmonitoring_pembayaranspk.periode_akhir',
            'tmmonitoring_pembayaranspk.spk_harga_progres',
            'tmmonitoring_pembayaranspk.spk_bayar_lalu',
            'tmmonitoring_pembayaranspk.spk_bayar_sekarang',
            'tmmonitoring_pembayaranspk.spk_bayar_tot',
            'tmmonitoring_pembayaranspk.spk_byr_sisa_lalu',
            'tmmonitoring_pembayaranspk.spk_bayar_sisa_skrg',
            'tmmonitoring_pembayaranspk.spk_byr_sisa_total'
        )
            ->join('tmmonitoring_pembayaranspk', 'tmprogres_spk.id', '=', 'tmmonitoring_pembayaranspk.tmprogres_spk_id', 'LEFT')
            ->join('tmrspk', 'tmrspk.id', '=', 'tmprogres_spk.tmrspk_id', 'LEFT')
            ->where(['tmprogres_spk.tmrspk_id' => $tmrspk_id, 'tmprogres_spk.spk_progress_tot' => $spk_progress_tot])
            ->first();
        $rsult = response()->json($datas);
        return $rsult;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->tmlevel_id == 2) {
            $pesan = 'anda tidak di perkenankan untuk menghapus data';
            return response()->json(['errors' => ['volume_spk' => [$pesan]]], 422);
        } else {
            try {
                if (is_array($this->request->id))
                    Tmprogres_spk::whereIn('id', $this->request->id)->delete();
                else
                    Tmprogres_spk::whereid($this->request->id)->delete();
                return response()->json([
                    'status' => 1,
                    'msg' => 'Data berhasil di hapus'
                ]);
            } catch (Tmprogres_spk $t) {
                return response()->json([
                    'status' => 2,
                    'msg' => $t
                ]);
            }
        }
    }
}
