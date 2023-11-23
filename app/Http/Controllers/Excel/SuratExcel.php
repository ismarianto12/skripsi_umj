<?php

namespace App\Http\Controllers\Excel;

use App\Models\Tmsurat_master;
use App\ReportController;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use Maatwebsite\Excel\Concerns\WithProperties;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Illuminate\Http\Request;

class SuratExcel implements ShouldAutoSize, FromView, WithEvents
{

    protected $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function view(): View
    {


        $data = Tmsurat_master::OrderBy('id','asc')->get();

        // Sikd_satker::find($this->request['tmsikd_satker_id']);
        return view('laporan.all_surat', [
            'data' => $data,

        ]);
    }
    public function registerEvents(): array
    {

        return [
            
            AfterSheet::class    => function (AfterSheet $event) {

                // $jumlahcell = $this->gettotal();


                // $event->sheet->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                // $event->sheet->getStyle('A2:H')->applyFromArray([
                //     'borders' => [
                //         'allBorders' => [
                //             'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                //             'color' => ['argb' => '000000'],
                //         ],
                //     ],
                // ]);
                // $event->sheet->mergeCells('A1:H1');

            },
        ];
    }
}
