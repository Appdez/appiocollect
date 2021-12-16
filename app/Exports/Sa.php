<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Sheet;
use \Maatwebsite\Excel\Writer;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class Sa implements FromCollection, ShouldAutoSize, WithStyles, WithColumnWidths, WithTitle
{
    private $collection;
    private $length;

    public function __construct($collection)
    {
        $this->collection = $collection;
        $this->length = collect($collection)->count();
    }
    public function title(): string
    {
        return "SA";
    }
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('a1:x'.$this->length)->getBorders()->applyFromArray([
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['rgb' => '000000'],
            ],
        ]);

        $sheet->mergeCells("a1:x2");
        $sheet->getStyle('A1:x2')->getFill()->applyFromArray(
            [
                'fillType' => Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 0,
                'startColor' => [
                    'rgb' => 'aed199'
                ],
                'endColor' => [
                    'argb' => 'aed199'
                ]
        ]);
        $sheet->getStyle('A3:x3')->getFill()->applyFromArray(
            [
                'fillType' => Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 0,
                'startColor' => [
                    'rgb' => 'a5abac'
                ],
                'endColor' => [
                    'argb' => 'a5abac'
                ]
        ]);
        //

            $sheet->getStyle('a1:x'.$this->length)->getAlignment()->applyFromArray(
                [
                    'horizontal'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                    'vertical'     => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'textRotation' => 0,
                    'wrapText'     => TRUE
                ]
        );
    }
    /**
     * @return Builder
     */
    public function collection()
    {
        return  $this->collection;
    }
    public function columnWidths(): array
    {
        return [];
    }
}
