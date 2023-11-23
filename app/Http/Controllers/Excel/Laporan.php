<?php

namespace App\Http\Controllers\Excel;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Http\Request;
use App\Models\Surat_report;
use App\Models\tmp_surat;
use App\Models\Tmsurat_master;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithEvents;

use Maatwebsite\Excel\Events\AfterSheet;

class Laporan implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    protected $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $column = $this->request->column_x;
        $jenis_sx = $this->request->jenis_sx;
        $inputan_user_xx = $this->request->inputan_user_xx;
        $column_partial =  [
            'SIP' => ["nomor_surat", "tanggal_surat"], // Jenis surat SIP
            'SIT' => ["nomor_surat", "tanggal_surat"], // Jenis surat SIT
            'SPH' => [
                "nomor_surat", "tanggal_surat", "nomor_surat_landlord",
                "perihal_surat_lanlord", "periode_sewa", "pic_landlord", "jabatan_landlord",
                "penawaran_harga_sewa"
            ], //dari jenis SPH
            'SMR' => [
                "harga_sewa_baru", "periode_awal", "periode_akhir", "penawaran_telkomsel",
                "penawaran_pemilik",
                "total_harga_sewa_baru",
                "keterangan_harga_patokan",

            ], //group by SMR
            'BAN' => [
                "tanggal_ban", "pengelola", "nama_pic", "nama_pic", "alamat_pic", "jabatan_pic",
                "nomor_telp_pic"
            ], //BAN
            'BAK' => [
                "nomor_bak", "lokasi_tempat_sewa", "luas_tempat_sewa", "nomor_rekening",
                "pemilik_rekening_bank", "Cabang", "nomor_npwp", "pemilik_npwp", "nomor_shm_ajb_hgb",
                "nomor_imb", "nomor_sppt_pbb", "total_harga_net"
            ]
        ];
        // dd($inputan_user_xx);

        if ($column == null && $inputan_user_xx == null) {

            return abort(404, 'data yang and cari tidak ada');
        } else {
            if ($column == null) {
                $dsata = [];
            } else {
                $dsata =  $column;
            }
            if ($inputan_user_xx == null) {
                $datasat = [];
            } else {
                $datasat =  $inputan_user_xx;
            }
            $c_satu  = isset($inputan_user_xx) ? $inputan_user_xx : [];
            $c_dua   = isset($column) ? $column : [];
            $columnset = array_merge($c_dua, $c_satu);
            $column_data = array_merge($dsata, $datasat);
            $jenis_surat = $this->request->jenis_surat_id;

            if ($jenis_surat == '') {
                return abort(404, 'Gagal server unknown load');
            }

            if ($inputan_user_xx == '') {
                return Tmsurat_master::select($column_data)->get();
            } else {
                $parsing = implode(',', $column_data);
                $parsing_csatu = implode(',', $c_satu);
                $condensed = implode(' IS NOT NULL ', $c_satu);
                $a  =  implode(' IS NOT NULL OR ', $c_satu);
                if (end($c_satu)) {
                    $j = $a . ' IS NOT NULL';
                } else {
                    $j = $a;
                }
                $g =  \DB::select("SELECT
                 $parsing 
            FROM
                 tmsurat_master
                LEFT JOIN 
                -- (SELECT DISTINCT tmp_surat.site_id, $parsing_csatu from tmp_surat where " . $j . " group BY tmp_surat.site_id) as
                 tmp_surat  
                ON 
                    tmsurat_master.site_id  = tmp_surat.site_id order by tmsurat_master.site_id");
                return collect($g);
            }
        }
    }


    public function headings(): array
    {
        $jenis_sx = $this->request->jenis_sx;
        $fparameter_satu = str_replace(['_', '.', 'tmp_surat', 'tmsurat_master', 'TMP_SURAT', 'TMSURAT_MASTER'], ' ', $this->request->column_x);
        $fparameter_dua  = str_replace(['_', '.', 'tmp_surat', 'tmsurat_master', 'TMP_SURAT', 'TMSURAT_MASTER'], ' ', $this->request->inputan_user_xx);

        // 
        $column = array_map('strtoupper',  $fparameter_satu);
        $inputan_user_xx = array_map('strtoupper', $fparameter_dua);
        $c_satu  = isset($inputan_user_xx) ? str_replace('tmp_surat.', '', $inputan_user_xx) : [];
        $c_dua   = isset($column) ? str_replace('tmsurat_master.', '', $column) : [];
        $columnset = array_merge($c_dua, $c_satu);
        return $columnset;
    }

    public function registerEvents(): array
    {

        return [
            AfterSheet::class    => function (AfterSheet $event) {

                $event->sheet->getDelegate()->getParent()->getDefaultStyle()->getFont()->setName('Arial');
                $event->getSheet()->getDelegate()->getStyle('A1:G1')->applyFromArray(
                    array(
                        'borders' => array(
                            'allborders' => array(
                                'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => array('rgb' => '000000')
                            )
                        )
                    )
                );
            },
        ];
    }
}
