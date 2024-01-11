<?php

namespace App\Http\Controllers;

use App\Models\tmp_surat;
use App\Models\Tmsurat_master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $view;
    protected $request;
    protected $route;

    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->request = $request;
        $this->view = '.home';
        $this->route = 'home';
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $tahun = $this->request->contract;
        $title = 'Welcome Page';
        $totalIncomeChart_cc = [];
        $master_surat = [];
        $percentage = [];
        $piedata = [];
        return view($this->view . '.home', compact('title', 'master_surat', 'totalIncomeChart_cc', 'piedata', 'percentage'));
    }

    public function pieData($par, $tahun)
    {
        $data = [
            'Closed BAK' => 'Closed BAK',
            'Closed PKS' => 'Closed PKS',
            'Closed PAID' => 'Closed PAID',
            'Closed (Catatan)' => 'Closed (Catatan)',
            'Negosiasi' => 'Negosiasi',
        ];

        $warna = [
            'Closed BAK' => '#12391b',
            'Closed PKS' => '#176128',
            'Closed PAID' => '#378349',
            'Closed (Catatan)' => '#8bec8d',
            'Negosiasi' => '#ddd',
        ];

        $totaly = \DB::select("SELECT (( SELECT count( site_id ) FROM tmsurat_master WHERE status_perpanjangan != '' AND tmsurat_master.tmtahun_id = '$tahun' ) / (
            SELECT
                count( tmsurat_master.id ) AS total
            FROM
                tmsurat_master

                INNER JOIN tr_surat_master ON tmsurat_master.site_id = tr_surat_master.site_id
                WHERE
                tmsurat_master.tmtahun_id = '$tahun'
            ) * 100
        ) AS TOTAL");
        $totalqr = $totaly[0]->TOTAL;
        if ($par == 'all') {
            foreach ($data as $datas) {
                $data = Tmsurat_master::where('status_perpanjangan', $datas)->where('tmtahun_id', $tahun)->count();
                if ($datas == 'Negosiasi') {
                    $negosiasi = Tmsurat_master::select(\DB::raw('count(id) as nego'))->where('tmtahun_id', $tahun)->first(); // \DB::select("");
                    $fnegosiasi = (int) $negosiasi->nego - (int) $data;
                    $rdata = (int) $fnegosiasi;
                } else {
                    $rdata = $data;
                }
                $row[] = [
                    'name' => $datas . ': ' . $rdata . ' Site',
                    'y' => $rdata,
                    'color' => $warna[$datas],
                ];
            }
            $rs = isset($row) ? $row : [];
            return $rs;

        } else {
            $data = DB::table('ACHIEVEMENT_PERCENT')->get();
            $res = substr($data[0]->TOTAL, 0, 5);
            return $totalqr;
        }
    }

    public function dashboard()
    {
    }

    // requre api
    public function all_site()
    {
        $all_site = Tmsurat_master::get()->count();
        return response()->json_encode($all_site);
    }

    public function percetage_all_site($cat)
    {
        if ($cat == 1) {
            $jenis = 'EASTERN JABOTABEK';
        } else if ($cat == 2) {
            $jenis = 'CENTRAL JABOTABEK';
        } else if ($cat == 3) {
            $jenis = 'WESTERN JABOTABEK';
        }
        $data = Tmsurat_master::select(\DB::raw('count(id) as jumlahny'))->from('tmsurat_master')->where('region', $jenis)->count();
        return response()->json([
            'cat_data' => $data,
        ]);
    }

    public function custom_number_format($n, $precision = 3)
    {
        if ($n < 1000000) {
            // Anything less than a million
            $n_format = number_format($n);
        } else if ($n < 1000000000) {
            // Anything less than a billion
            $n_format = number_format($n / 1000000, $precision) . 'M';
        } else {
            // At least a billion
            $n_format = number_format($n / 1000000000, $precision) . 'B';
        }

        return $n_format;
    }
    // show data from this page use this line
    public function table_data()
    {
        $jenis = $this->request->jenis;
        $tahun = $this->request->tahun;
        // dd($)
        $back = Tmsurat_master::join('tr_surat_master', 'tr_surat_master.site', '=', 'tmsurat_master.site_id')->where('tmsurat_master.tmtahun_id', $tahun);
        $periode = $this->request->periode;
        if ($periode == '1') {
            $fperiode = '3';
        } else
            if ($periode == '2') {
                $fperiode = '6';
            } else
                if ($periode == '3') {
                    $fperiode = '9';
                } else
                    if ($periode == '4') {
                        $fperiode = '12';
                    } else {
                        $fperiode = '12';
                    }

        $y = date('Y');
        if ($jenis == 'cos_saving') {
            if ($this->request->periode != 0) {

                $origin = Tmsurat_master::select(\DB::raw("sum(replace(harga_patokan,',','')) as fharga_patokan"))
                    ->join('tmp_surat', 'tmp_surat.site_id', '=', 'tmsurat_master.site_id')
                    ->join('tr_surat_master', 'tr_surat_master.site_id', '=', 'tmsurat_master.site_id')->where('tmsurat_master.tmtahun_id', $tahun);

                $compare = tmp_surat::select(\DB::raw("sum(replace(harga_sewa_baru,'.','')) as tharga_sewa_baru"))->where('tmsurat_master.tmtahun_id', $tahun)->join('tmsurat_master', 'tmp_surat.site_id', '=', 'tmsurat_master.site_id');
                if ($periode == '1') {
                    $origin->where("tmsurat_master.quartal", "Q1")->get();
                    $compare->where("tmsurat_master.quartal", "Q1")->get();
                } else
                    if ($periode == '2') {
                        // origin start
                        $origin->where("tmsurat_master.quartal", "Q2")->get();
                        $compare->where("tmsurat_master.quartal", "Q2")->get();
                    } else
                        if ($periode == '3') {
                            $origin->where("tmsurat_master.quartal", "Q3")->get();
                            $compare->where("tmsurat_master.quartal", "Q3")->get();
                        } else
                            if ($periode == '4') {
                                $origin->where("tmsurat_master.quartal", "Q4")->get();
                                $compare->where("tmsurat_master.quartal", "Q4")->get();
                            } else {
                                $origin->get();
                                $compare->get();
                            }
                $c_saving = ($origin->first()->fharga_patokan - $compare->first()->tharga_sewa_baru);
                $fharga_patokan = $origin->first()->fharga_patokan;
                if ($origin->first()->fharga_patokan < 0 || $origin->first()->fharga_patokan == null) {
                    $percetage = 0;
                } else {
                    $percetage = (($c_saving / $fharga_patokan) * 100);
                }
                $amount = number_format((int) $c_saving);
                $a = [
                    'percentage' => ($percetage) ? substr($percetage, 0, 5) . '%' : '0%',
                    'amount' => ($amount) ? $amount : 0,
                ];
            } else {
                $origin = Tmsurat_master::select(\DB::raw("sum(replace(harga_patokan,',','')) as fharga_patokan"))
                    ->join('tmp_surat', 'tmp_surat.site_id', '=', 'tmsurat_master.site_id')
                    ->join('tr_surat_master', 'tr_surat_master.site_id', '=', 'tmsurat_master.site_id')->where('tmsurat_master.tmtahun_id', $tahun)->get();

                $compare = tmp_surat::select(\DB::raw("sum(replace(harga_sewa_baru,'.','')) as tharga_sewa_baru"))->where('tmsurat_master.tmtahun_id', $tahun)->join('tmsurat_master', 'tmp_surat.site_id', '=', 'tmsurat_master.site_id')
                    ->get();

                // Show results of log
                $c_saving = ($origin->first()->fharga_patokan - $compare->first()->tharga_sewa_baru);
                if ($c_saving > 0) {
                    if ($compare->first()->tharga_sewa_baru > 0) {
                        $amount = number_format((int) $c_saving);
                        $percetage = (($c_saving / (int) $origin->first()->fharga_patokan) * 100);
                        $setpercentage = substr($percetage, 0, 5);
                    } else {
                        $amount = 0;
                        $setpercentage = 0;

                    }
                    $a = [
                        'percentage' => ($setpercentage) . '%',
                        'amount' => ($amount) ? $amount : 0,
                    ];
                } else {
                    $a = [
                        'percentage' => '0%',
                        'amount' => 0,
                    ];

                }
            }
        } else if ($jenis == 'ef_eficiency') {

            $eorigin = tmp_surat::select(\DB::raw("sum(replace(pemilik_1,'.','')) as penawaran_ttl"))->where('tmsurat_master.tmtahun_id', $tahun)->join('tmsurat_master', 'tmp_surat.site_id', '=', 'tmsurat_master.site_id');
            $ecompare = tmp_surat::select(\DB::raw("sum(replace(harga_sewa_baru,'.','')) as tharga_sewa_baru"))->where('tmsurat_master.tmtahun_id', $tahun)->join('tmsurat_master', 'tmp_surat.site_id', '=', 'tmsurat_master.site_id');

            if ($periode == '1') {

                $eorigin->where("tmsurat_master.quartal", "Q1")->get();
                $ecompare->where("tmsurat_master.quartal", "Q1")->get();
            } else if ($periode == '2') {

                $eorigin->where("tmsurat_master.quartal", "Q2")->get();
                $ecompare->where("tmsurat_master.quartal", "Q2")->get();
            } else if ($periode == '3') {

                $eorigin->where("tmsurat_master.quartal", "Q3")->get();
                $ecompare->where("tmsurat_master.quartal", "Q3")->get();
            } else if ($periode == '4') {
                $eorigin->where("tmsurat_master.quartal", "Q4")->get();
                $ecompare->where("tmsurat_master.quartal", "Q4")->get();
            } else {
                $eorigin->get();
                $ecompare->get();
            }

            $efficiency = ((int) $eorigin->first()->penawaran_ttl - (int) $ecompare->first()->tharga_sewa_baru);
            $hargaperatama = isset($eorigin->first()->penawaran_ttl) ? $eorigin->first()->penawaran_ttl : 1;
            if ($this->request->periode != 0) {
                if ($efficiency > 0) {
                    $percetage = (((int) $efficiency / (int) $hargaperatama) * 100);
                    $amount = number_format((int) $efficiency);
                    $a = [
                        'percentage' => ($percetage) ? substr($percetage, 0, 6) . '%' : '0%',
                        'amount' => ($amount) ? $amount : '0',
                    ];

                } else {
                    $percetage = 0;
                    $amount = number_format((int) $efficiency);
                    $a = [
                        'percentage' => ($percetage) ? substr($percetage, 0, 6) . '%' : '0%',
                        'amount' => ($amount) ? $amount : '0',
                    ];

                }
            } else {

                $eorigin = tmp_surat::select(\DB::raw("sum(replace(pemilik_1,'.','')) as penawaran_ttl"))->where('tmsurat_master.tmtahun_id', $tahun)->join('tmsurat_master', 'tmp_surat.site_id', '=', 'tmsurat_master.site_id')
                    ->get();

                $compare = tmp_surat::select(\DB::raw("sum(replace(harga_sewa_baru,'.','')) as tharga_sewa_baru"))->where('tmsurat_master.tmtahun_id', $tahun)->join('tmsurat_master', 'tmp_surat.site_id', '=', 'tmsurat_master.site_id')
                    ->get();

                $c_saving = ((int) $eorigin->first()->penawaran_ttl - (int) $compare->first()->tharga_sewa_baru);
                $amount = number_format($c_saving);
                if ($eorigin->first()->penawaran_ttl > 0) {

                    $percetage = (($c_saving / $eorigin->first()->penawaran_ttl) * 100);
                } else {
                    $percetage = 0;
                }
                $a = [
                    'percentage' => substr($percetage, 0, 6) . '%',
                    'amount' => ($amount) ? $amount : '0',
                ];
            }
        }

        return response()->json($a);
    }
    private function based_on_revenue()
    {
        if ($this->request->contract) {
            $site_jabodetabek = Tmsurat_master::where('tmtahun_id', $this->request->contract)->get()->count();
        } else {
            $site_jabodetabek = Tmsurat_master::get()->count();
        }

        return $site_jabodetabek;
    }

    public function cregion($par, $tahun)
    {

        if ($tahun != '') {
            $jumlah = Tmsurat_master::where('region', $par)
                ->where('tmtahun_id', $tahun)
                ->count();
        } else {
            $jumlah = Tmsurat_master::where('region', $par)
                ->count();
        }
        if ($this->based_on_revenue() > 0) {
            $nil = (intval($jumlah) / intval($this->based_on_revenue()) * 100);
        } else {
            $nil = 0;
        }
        return round($nil) . '%';
    }
    public function site_jabodetabek()
    {
        return $this->based_on_revenue();
    }
    public function pr_western_jabo()
    {
        $contract = $this->request->contract;
        return $this->cregion('WESTERN JABOTABEK', $contract);
    }
    public function pr_centeral_jabo()
    {
        $contract = $this->request->contract;

        return $this->cregion('CENTRAL JABOTABEK', $contract);
    }
    public function pr_eastern_jabo()
    {
        $contract = $this->request->contract;

        return $this->cregion('EASTERN JABOTABEK', $contract);
    }
    // left grafik

    public function graph_revenue()
    {
        // $ar_cat = [
        //     '#N/A',
        //     'BRONZE',
        //     'SILVER',
        //     'GOLD',
        //     'PLATINUM',
        //     'DIAMOND',
        // ];

        // // dd($this->based_on_revenue());
        // $tahunid = $this->request->periode;
        // foreach ($ar_cat as $lsdata) {
        //     if ($tahunid != '') {
        //         $jumlah = Tmsurat_master::select(\DB::raw('count(id) as ll'))->where('revenue_cat', $lsdata)->where('tmtahun_id', $tahunid)
        //             ->first();
        //         if ($this->based_on_revenue() > 0) {
        //             $nil = (intval($jumlah->ll) / intval($this->based_on_revenue()) * 100);
        //         } else {
        //             $nil = 0;
        //         }
        //     } else {
        //         $jumlah = Tmsurat_master::select(\DB::raw('count(id) as ll'))->where('revenue_cat', $lsdata)
        //             ->first();
        //         if ($this->based_on_revenue() > 0) {
        //             $nil = (intval($jumlah->ll) / intval($this->based_on_revenue()) * 100);
        //         } else {
        //             $nil = 0;
        //         }

        //     }
        //     $passedata[] = round($nil);

        // }
        // dd($this->request->contract);

        if ($this->request->contract == 2022) {
            $data = DB::table('Revenue2022')->get();
        } else {
            $data = DB::table('Revenue2023')->get();
        }
        // dd($data[0]);

        //     $ff = '';
        // foreach ($data as $key => $value) {
        //     # code...
        //     $ff = $value[]

        // }

        $ar_cat = [
            round($data[0]->NO_REVENUE, STR_PAD_RIGHT),
            round($data[0]->BRONZE, STR_PAD_RIGHT),
            round($data[0]->SILVER, STR_PAD_RIGHT),
            round($data[0]->GOLD, STR_PAD_RIGHT),
            round($data[0]->PLATINUM, STR_PAD_RIGHT),
            round($data[0]->DIAMOND, STR_PAD_RIGHT),
        ];
        $frpassed = implode(',', $ar_cat);
        return $frpassed;
    }
    // persentase perhitungan
    public function saving_filter()
    {
        $periode = $this->request->periode;
        if ($periode == 0) {
            $cost_saving = '';
            $cs_percentage = '';
            $cs_amount = '';

            $efiency = '';
            $ef_percentage = '';
            $ef_amount = '';
        } else {
            $data = Tmsurat_master::join('tr_surat_master', 'tr_surat_master.site_id', '=', 'tmsurat_master.site_id', 'left');

            if ($periode == 1) {
            } elseif ($periode == 2) {
            } else if ($periode == 3) {
            }

            $cost_saving = '';
            $cs_percentage = '';
            $cs_amount = '';

            $efiency = '';
            $ef_percentage = '';
            $ef_amount = '';
        }
    }
}
