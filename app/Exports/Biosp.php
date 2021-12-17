<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithProperties;

class Biosp implements WithMultipleSheets,WithProperties
{
    use Exportable;
    protected $collection;

    public function __construct($collection)
    {
        $this->collection = $collection;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        return [
            new Sa($this->collection)
        ];
    }

    public function properties(): array
    {
        return [
            'creator'        => 'Nelson Alexandre Mutane; Edson Tantenda Meque',
            'lastModifiedBy' => 'Nelson Alexandre Mutane; Edson Tantenda Meque',
            'title'          => 'App 10 Collector',
            'description'    => 'Relatório de dados collectados',
            'subject'        => 'Relatórios',
            'keywords'       => 'Relatórios,Dados,excel',
            'category'       => 'Relatórios',
            'manager'        => 'Nelson Alexandre Mutane; Edson Tantenda Meque',
            'company'        => 'App10',
        ];
    }

}

