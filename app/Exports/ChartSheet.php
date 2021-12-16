<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCharts;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Title;

class ChartSheet implements FromCollection,WithCharts,WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect([]);
    }

    public function charts()
    {

        $labels = [
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Relatório!$A$7', null),
            ];
        $categories = [
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Relatório!$A$8:$A$9', null,4),
            ];
        $values = [
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, 'Relatório!$B$7:$B$8', null)
            ];

        $chart1 = new Chart(
            'Relatório',
            new Title('N° de pessoas acolhidas e registadas nos BIOSP- Sala de Informação'),
            new Legend(),
            new PlotArea(null, [
                new DataSeries(
                    DataSeries::TYPE_PIECHART_3D, null,
                     range(0, count($values) - 1),
                     $labels,
                      $categories,
                       $values,
                       null,
                       false,
                       "style9"

                       )
            ])
        );
        $chart1->setTopLeftCell("A1");
        $chart1->setBottomRightCell("J20");

        return $chart1;
    }

    public function title(): string
    {
        return "Relatótorio Gráfico";
    }
}
