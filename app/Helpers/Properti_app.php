<?php

// by ismarianto
namespace App\Helpers;

use App\Models\Jenis_surat;
use App\Models\User;
use App\Models\Setupsikd\Tmsikd_satker;
use App\Models\Setupsikd\Tmsikd_setup_tahun_anggaran;
use App\Models\Tmbangunan;
use App\Models\Tmproyek;
use App\Models\Tmrap;
use App\Models\Tmsurat_master;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;

// use Illuminate\Support\Facades\Session;

class Properti_app
{

    public static function status_perpanjang()
    {
        return [
            'Closed BAK' => 'Closed BAK',
            'Closed PKS' => 'Closed PKS',
            'Closed PAID' => 'Closed PAID',
            'Closed (Catatan)' => 'Closed (Catatan)'
        ];
    }
    function jenjangPeg()
    {
        return [
            1 => 'Tenaga Pendidik',
            2 => 'Tenaga Kependidikan'
        ];
    }

    public static function jenjangApp()
    {
        return [
            'S3' => 'S3',
            'S2' => 'S2',
            'S1' => 'S1',
            'DIII' => 'DIII'
        ];
    }

    public static function JenisKel()
    {
        return [
            'L' => 'Laki-Laki',
            'P' => 'Perempuan'
        ];
    }
    public function jenisSurat()
    {
    }
    public static function hari($hari)
    {
        switch ($hari) {
            case 'Sun':
                $hari_ini = "Minggu";
                break;

            case 'Mon':
                $hari_ini = "Senin";
                break;

            case 'Tue':
                $hari_ini = "Selasa";
                break;

            case 'Wed':
                $hari_ini = "Rabu";
                break;

            case 'Thu':
                $hari_ini = "Kamis";
                break;

            case 'Fri':
                $hari_ini = "Jumat";
                break;

            case 'Sat':
                $hari_ini = "Sabtu";
                break;

            default:
                $hari_ini = "Tidak di ketahui";
                break;
        }
        return $hari_ini;
    }
    public function number_format()
    {
    }

    public static function user_satker()
    {
        $user_id = Auth::user()->id;
        $query = DB::table('user')
            ->select('user.id', 'user.username', 'tmuser_level.description', 'tmuser_level.mapping_sie', 'tmuser_level.id as level_id')
            ->join('tmuser_level', 'user.tmuser_level_id', '=', 'tmuser_level.id')
            ->where('user.id', $user_id);

        $levelid = $query->first()->level_id;
        if ($levelid == 3) {
            return Auth::user()->sikd_satker_id;
        } else {
            return 0;
        }
    }

    public static function load_js(array $url)
    {
        $data = [];
        foreach ($url as $ls) {
            $js[] = '<script type="text/javascript" src="' . $ls . '"></script>';
            $data = $js;
        }
        return $data;
    }


    public static function getlevel()
    {
        $ff = Auth::user();
        // dd($user_id);
        if ($ff != null) {
            $user_id = $ff->id;
            $query = DB::table('users')
                ->select('users.id', 'users.username', 'tmuser_level.description', 'tmuser_level.mapping_sie', 'tmuser_level.id as level_id')
                ->join('tmuser_level', 'users.tmuser_level_id', '=', 'tmuser_level.id')
                ->where('users.id', $user_id)
                ->first();
            return $query->level_id;
        } else {
            return null;
        }
    }


    public static function tgl_indo($tgl)
    {
        $bulan = array(
            1 => 'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $split = explode('-', $tgl);
        return $split[2] . ' ' . $bulan[(int) $split[1]] . ' ' . $split[0];
    }

    public static function servername()
    {
        return $_SERVER['HTTP_HOST'];
    }
    public static function UserSess()
    {
        $ff = Auth::user();
        if ($ff != null) {
            return $ff->username;
        } else {
            return null;
        }
    }

    public static function propuser($params)
    {
        $ff = Auth::user();
        if ($ff != null) {
            $data = User::find($ff->id);
            // dd($data);
            if ($data != '') {
                return $data[$params];
            } else {
                return NULL;
            }
        } else {
            return NULL;
        }
    }



    public static function comboproyek($id = '')
    {
        $level_id = Auth::user()->level_id;
        $id_user = Auth::user()->id;
        $datas = User::select(
            'users.id as ltjk',
            'users.name',
            'users.username',
            'users.tmlevel_id',
            'users.tmproyek_id',
            'tmproyek.nama_proyek',
            'tmproyek.kode',
            'tmproyek.id'
        )->join('tmproyek', 'tmproyek.id', '=', 'users.tmproyek_id')
            ->where('users.id', $id_user)
            ->get();

        // dd($level_id);
        if (self::propuser('tmlevel_id') != 1) {
            // dd('sss');
            $html = '<select id="tmproyek_id" name="tmproyek_id" class="js-example-basic-single form-control">';
            foreach ($datas as $data) {
                $selected = ($data->id == $id) ? 'selected' : '';
                $html .= '<option value="' . $data['id'] . '" ' . $selected . '>' . $data['kode'] . '-' . $data['nama_proyek'] . '</option>';
            }
            $html .= '</select>';
        } else {
            $html = '<select id="tmproyek_id" name="tmproyek_id" class="js-example-basic-single form-control">';
            $dds = Tmproyek::get();
            // dd($dds);
            $html .= '<option value="">--Semua Proyek-- </option>';
            foreach ($dds as $dd) {
                $selected = ($dd->id == $id) ? 'selected' : '';

                $html .= '<option value="' . $dd['id'] . '" ' . $selected . '>' . $dd['kode'] . '-' . $dd['nama_proyek'] . '</option>';
            }
            $html .= '</select>';
        }
        return $html;
    }

    public static function combobangunan($id = '')
    {
        $level_id = Auth::user()->level_id;
        $datas = Tmbangunan::select('kode', 'nama_bangunan', 'id');

        if ($level_id != 1) {
            $html = '<select name="tmbangunan_id" class="js-example-basic-single form-control">';
            $pars = $datas->where('tmlevel_id', $level_id);
            foreach ($pars->get() as $data) {
                $selected = ($data->id == $id) ? 'selected' : '';
                $html .= '<option value="' . $data['id'] . '" ' . $selected . '>' . $data['kode'] . '-' . $data['nama_proyek'] . '</option>';
            }
            $html .= '</select>';
        } else {
            $html = '<select name="tmbangunan_id" class="js-example-basic-single form-control">';
            $pars = $datas->get();
            foreach ($pars as $data) {
                $selected = ($data->id == $id) ? 'selected' : '';
                $html .= '<option value="' . $data['id'] . '" ' . $selected . '>' . $data['kode'] . '-' . $data['nama_proyek'] . '</option>';
            }
            $html .= '</select>';
        }
        return $html;
    }

    public static function jenis_surat()
    {

        $a = [
            'SIP' => 'SURAT INFORMASI PERPANJANGAN',
            'SIT' => 'SURAT INFORMASI TIDAK PERPANJANG',
            'SPH' => 'SURAT PENAWARAN HARGA',
            'SMR' => 'SUMMARY',
            'BAN' => 'BERITA ACARA NEGOSIASI',
            'BAK' => 'BERITA ACARA KESEPAKATAN',
        ];
        return $a;
    }

    // set change environment dinamically
    public static function parsing($url)
    {
        $val = "?" . base64_decode($url);
        $query_str = parse_url($val, PHP_URL_QUERY);
        parse_str($query_str, $query_params);
        return $query_params;
    }
    public static function no_surat()
    {
        $s = Tmsurat_master::select(\DB::raw('max(download) as idnya'))->first();
        $rdata = isset($s->idnya) ? (int) $s->idnya : 1 + 1;
        return $rdata;
    }



    // self return function


    public static function penyebut($nilai)
    {
        $nilai = abs($nilai);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = self::penyebut($nilai - 10) . " belas";
        } else if ($nilai < 100) {
            $temp = self::penyebut($nilai / 10) . " puluh" . self::penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . self::penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = self::penyebut($nilai / 100) . " ratus" . self::penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . self::penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = self::penyebut($nilai / 1000) . " ribu" . self::penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = self::penyebut($nilai / 1000000) . " juta" . self::penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = self::penyebut($nilai / 1000000000) . " milyar" . self::penyebut(fmod($nilai, 1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = self::penyebut($nilai / 1000000000000) . " trilyun" . self::penyebut(fmod($nilai, 1000000000000));
        }
        return $temp;
    }

    public static function terbilang($nilai)
    {
        if ($nilai < 0) {
            $hasil = "minus " . trim(self::penyebut($nilai));
        } else {
            $hasil = trim(self::penyebut($nilai));
        }
        return $hasil;
    }

    public static function bulan()
    {

        return array(
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
    }

    public static function parameterColumn()
    {
        return [
            'SIP' => [
                "nomor_surat" => "Nomor Surat",
                "tanggal_surat" => "Tanggal Surat"
            ], // Jenis surat SIP
            'SIT' => [
                "nomor_surat" => "Nomor Surat",
                "tanggal_surat" => "Tanggal Surat"
            ], // Jenis surat SIT
            'SPH' => [
                "nomor_surat" => "Nomor Surat",
                "tanggal_surat" => "Tanggal Surat",
                "nomor_surat_landlord" => "Nomor Surat Landlord",
                "perihal_surat_landlord" => "Perihal Surat Landlord",
                'periode_sewa_penawaran_awal' => "Periode Sewa Penawaran Awal",
                'periode_sewa_penawaran_akhir' => "Periode Sewa Penawaran Akhir",
                "pic_landlord" => "Pic Landlord",
                "jabatan_landlord" => "Jabatan Landlord",
                "penawaran_harga_sewa" => "Penawaran Harga Sewa"
            ], //dari jenis SPH
            'SMR' => [
                "harga_sewa_baru" => 'Harga Sewa Baru',
                "periode_awal" => 'Periode Awal',
                "periode_akhir" => 'Periode Akhir',
                // "penawaran_pemilik" => 'Penawaran pemilik',
                "penawaran_th_1" => 'Penawaran Telkomsel 1',
                "penawaran_th_2" => 'Penawaran Telkomsel 2',
                "penawaran_th_3" => 'Penawaran Telkomsel 3',
                "penawaran_th_4" => 'Penawaran Telkomsel 4',
                "pemilik_1" => "Penawaran Pemilik  1",
                "pemilik_2" => "Penawaran Pemilik 2",
                "pemilik_3" => "Penawaran Pemilik 3",
                "pemilik_4" => "Penawaran Pemilik 4",
                "total_harga_sewa_baru" => "Total Harga Sewa baru",
                "keterangan_harga_patokan" => "Keterangan Harga Patokan"
            ], //group by SMR
            'BAN' => [
                "tanggal_ban" => "Tanggal",
                "pengelola" => "Pengelola",
                "nama_pic" => "Nama PIC",
                "alamat_pic" => "Alamat PIC",
                "jabatan_pic" => "Jabatan PIC",
                "nomor_telp_pic" => "Nomor Telephone PIC"
            ], //BAN
            'BAK' => [
                "nomor_bak" => "Nomor Surat BAK",
                "lokasi_tempat_sewa" => "Lokasi Tempate Sewa",
                "luas_tempat_sewa" => "Luas Tempat Sewa",
                "nomor_rekening" => "Nomor Rekening",
                "pemilik_rekening_bank" => "Pemilik Rekening Bank",
                "cabang" => "Cabang",
                "nomor_npwp" => "Nomor NPWP",
                "pemilik_npwp" => "Pemilik NPWP",
                "nomor_shm_ajb_hgb" => "Nomor SHM / AJB HGB",
                "nomor_imb" => "Nomor IMB",
                "nomor_sppt_pbb" => 'Nomor SPT PBB',
                "total_harga_net" => "Total Harga NET"
            ]
        ];
    }

    public static function format_percentage($percentage, $precision = 2)
    {
        return round($percentage, $precision) . '%';
    }

    public static function calculate_percentage($number, $total)
    {

        // Can't divide by zero so let's catch that early.
        if ($total == 0) {
            return 0;
        }

        return ($number / $total) * 100;
    }

    public static function calculate_percentage_for_display($number, $total)
    {
        return self::format_percentage(self::calculate_percentage($number, $total));
    }

    public static function getKelas()
    {
        return DB::table('kelas')->get();
    }
    public static function getUserLogin()
    {

        $levelid = Auth::user()->level_id;
        if ($levelid === '3') {
            return DB::table('kelas')->get();
        } else {
            return Auth::user()->username;
        }
    }
    public static function guruid($parameter = 'id')
    {
        $username = Auth::user()->username;
        $userdata = DB::table('karyawan')->where('nik', $username)->where('status', '1')->first();
        return isset($userdata->$parameter) ? $userdata->$parameter : '';
    }
    function statusHadir()
    {
        return [
            'H' => 'Hadir',
            'A' => 'Alpha',
            'I' => 'Izin',
            'S' => 'Sakit',
            
        ];

    }
}
