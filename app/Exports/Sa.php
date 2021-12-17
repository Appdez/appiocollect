<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class Sa implements FromCollection, ShouldAutoSize, WithStyles, WithColumnWidths, WithTitle
{
    private $collection;
    private $length;

    public function __construct($collection)
    {
        $this->collection = $collection;
        $this->length = collect($collection[0])->count();

    }
    public function title(): string
    {
        return "BD";
    }
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('a1:j'.$this->length)->getBorders()->applyFromArray([
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['rgb' => '000000'],
            ],
        ]);

        $sheet->mergeCells("a1:j2");
        $sheet->getStyle('A1:j2')->getFill()->applyFromArray(
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
        $sheet->getStyle('A3:j3')->getFill()->applyFromArray(
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
        $sheet->getStyle('a1:j3')->getAlignment()->applyFromArray(
            [
                'horizontal'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical'     => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'textRotation' => 0,
                'wrapText'     => TRUE
            ]
    );
            $sheet->getStyle('a4:j'.$this->length)->getAlignment()->applyFromArray(
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
