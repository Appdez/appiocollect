<?php

namespace App\Traits;

trait SumProduct
{
    use Relatorio;

    /**
     *@return =SUMPRODUCT(SUBTOTAL(103,OFFSET(SA!D4:D998,ROW(SA!D4:D998)-ROW(SA!D4),0,1)),--(SA!J4:J998="4.Tem uma preocupação concreta"),--(SA!D4:D998="Masculino"))
     **/

    public  function sumProduct(int $function, string $sheet, string $idCol, string $startRange, String $endRange, array $colls)
    {
        $baseRange = "{$sheet}!{$idCol}{$startRange}:{$idCol}{$endRange}";
        $offset = "OFFSET({$baseRange},ROW({$baseRange}) - ROW({$sheet}!{$idCol}{$startRange}),0,1)";
        $subtotal = "SUBTOTAL({$function},{$offset})";
        $conditions = "";
        $index = 0;
        foreach ($colls as $key => $value) {
            $conditions .= "--($sheet!{$key}{$startRange}:{$key}{$endRange} = \"{$value}\")";
            if (($index + 1) != collect($colls)->count()) $conditions .= ",";
            $index++;
        }
        return  "=SUMPRODUCT({$subtotal}, $conditions)";
    }
}
