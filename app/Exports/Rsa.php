<?php

namespace App\Exports;

use App\Models\ForwardedService;
use App\Models\Genre;
use App\Models\PurposeOfVisit;
use App\Models\ReasonOpeningCase;
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
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Sheet;
use \Maatwebsite\Excel\Writer;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\PseudoTypes\False_;

class Rsa implements FromCollection, ShouldAutoSize, WithStyles, WithColumnWidths, WithTitle
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
        return "Relatório";
    }
    public function styles(Worksheet $sheet)
    {

        $sheet->mergeCells('a1:b6');
        $sheet->getStyle('a1:b1')->getAlignment()->applyFromArray(
            [
                'horizontal'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical'     => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'textRotation' => 0,
                'wrapText'     => FALSE
            ]
        );
        $sheet->getStyle('a1:b1')->getFont()->applyFromArray(
            [
                'name'      =>  'Arial',
                'size'      =>  10,
                'bold'      =>  true
            ]
        );

        $sheet->getStyle('a1:b' . $this->length)->getBorders()->applyFromArray([
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['rgb' => '000000'],
            ],
        ]);
        function random_color_part()
        {
            return str_pad(dechex(mt_rand(210, 255)), 2, '0', STR_PAD_LEFT);
        }

        function random_color()
        {
            return random_color_part() . random_color_part(). random_color_part();
        }
        $i = 5;
        $color = random_color();
        ++$i;
        $sheet->mergeCells("A{$i}:B$i");
        ++$i;
                $sheet->getStyle("A$i:b$i")->getFill()->applyFromArray(
                    [
                        'fillType' => Fill::FILL_GRADIENT_LINEAR,
                        'rotation' => 0,
                        'startColor' => [
                            'rgb' =>  $color
                        ],
                        'endColor' => [
                            'argb' => $color
                        ]
                    ]
                );
        foreach (Genre::all() as $value) {
            ++$i;
            $sheet->getStyle("A$i:b$i")->getFill()->applyFromArray(
                [
                    'fillType' => Fill::FILL_GRADIENT_LINEAR,
                    'rotation' => 0,
                    'startColor' => [
                        'rgb' =>  $color
                    ],
                    'endColor' => [
                        'argb' => $color
                    ]
                ]
            );
        }
        ++$i;
        $sheet->mergeCells("A{$i}:B$i");
        $color = random_color();
        foreach (PurposeOfVisit::all() as  $value) {
            ++$i;
            $sheet->getStyle("A$i:b$i")->getFill()->applyFromArray(
                [
                    'fillType' => Fill::FILL_GRADIENT_LINEAR,
                    'rotation' => 0,
                    'startColor' => [
                        'rgb' =>  $color
                    ],
                    'endColor' => [
                        'argb' => $color
                    ]
                ]
            );
            foreach (Genre::all() as $genre) {
                ++$i;
                $sheet->getStyle("A$i:b$i")->getFill()->applyFromArray(
                    [
                        'fillType' => Fill::FILL_GRADIENT_LINEAR,
                        'rotation' => 0,
                        'startColor' => [
                            'rgb' =>  $color
                        ],
                        'endColor' => [
                            'argb' => $color
                        ]
                    ]
                );
            }
        }
        ++$i;
        $sheet->mergeCells("A{$i}:B$i");
        $color = random_color();
        foreach (ReasonOpeningCase::all() as  $value) {
            ++$i;
            $sheet->getStyle("A$i:b$i")->getFill()->applyFromArray(
                [
                    'fillType' => Fill::FILL_GRADIENT_LINEAR,
                    'rotation' => 0,
                    'startColor' => [
                        'rgb' =>  $color
                    ],
                    'endColor' => [
                        'argb' => $color
                    ]
                ]
            );
        }
        ++$i;
        $sheet->mergeCells("A{$i}:B$i");
        $color = random_color();
        foreach (ForwardedService::all() as  $value) {
            ++$i;
            $sheet->getStyle("A$i:b$i")->getFill()->applyFromArray(
                [
                    'fillType' => Fill::FILL_GRADIENT_LINEAR,
                    'rotation' => 0,
                    'startColor' => [
                        'rgb' =>  $color
                    ],
                    'endColor' => [
                        'argb' => $color
                    ]
                ]
            );
            foreach (Genre::all() as $genre) {
                ++$i;
                $sheet->getStyle("A$i:b$i")->getFill()->applyFromArray(
                    [
                        'fillType' => Fill::FILL_GRADIENT_LINEAR,
                        'rotation' => 0,
                        'startColor' => [
                            'rgb' =>  $color
                        ],
                        'endColor' => [
                            'argb' => $color
                        ]
                    ]
                );
            }
        }
        ++$i;
        $sheet->mergeCells("a{$i}:B$i");
        $color = random_color();
        foreach (ForwardedService::all() as  $value) {
            ++$i;
            $sheet->getStyle("A$i:b$i")->getFill()->applyFromArray(
                [
                    'fillType' => Fill::FILL_GRADIENT_LINEAR,
                    'rotation' => 0,
                    'startColor' => [
                        'rgb' =>  $color
                    ],
                    'endColor' => [
                        'argb' => $color
                    ]
                ]
            );
        }

        //#bbd8f2
        $sheet->getStyle("b7:b{$this->length}")->getFill()->applyFromArray(
            [
                'fillType' => Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 0,
                'startColor' => [
                    'rgb' =>  "bbd8f2"
                ],
                'endColor' => [
                    'argb' => "bbd8f2"
                ]
            ]
        );
    }
    /**
     * @return Builder
     * */

    public function collection()
    {
        return  $this->collection;
    }
    public function columnWidths(): array
    {
        return [
            'a' => 70
        ];
    }
}
