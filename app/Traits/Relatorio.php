<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use App\Models\ForwardedService;
use App\Models\Genre;
use App\Models\PurposeOfVisit;
use App\Models\ReasonOpeningCase;

/**
 *
 */
trait Relatorio
{
    public function relatorio($dataCollection, $bairro): Collection
    {
        $arr = array();
        $arr[0] = collect(["RELATÓRIO BASE DE DADOS DE REGISTO DO BENEFICIAIRO - BIOSP - $bairro "]);

        for ($i=1; $i < 6 ; $i++) {
            $arr[$i] = collect([
                ""
            ]);
        }
        $index = 7;
        $length = $dataCollection->count() + 4;
        $arr[++$index] = collect(["N° de pessoas acolhidas e registadas nos BIOSP- Sala de Informação ", "=SUBTOTAL(103,SA!A4:A{$length})"]);
        foreach (Genre::all() as $value) {
            $arr[++$index] = collect(
                [
                    "Inclusive do sexo $value->name",
                    $this->sumProduct(103, "SA", "A", "4", "$length", ["D" => "$value->name"])
                ]
            );
        }
        $arr[++$index] = collect(["Benificiarios que vieram ao Biosp com os seguintes objectivos"]);
        foreach (PurposeOfVisit::all() as  $value) {
            $arr[++$index] = collect(
                [
                    "$value->name",
                    $this->sumProduct(103, "SA", "A", "4", "$length", ["J" => "$value->name"])
                ]
            );
            foreach (Genre::all() as $genre) {
                $arr[++$index] = collect(
                    [
                        "   Inclusive do sexo $genre->name",
                        $this->sumProduct(103, "SA", "A", "4", "$length", ["J" => "$value->name", "D" => "$genre->name"])
                    ]
                );
            }
        }
        $arr[++$index] = collect(["Benificiarios que que abriram seus processos com os seguintes motivos "]);
        foreach (ReasonOpeningCase::all() as  $value) {
            $arr[++$index] = collect(
                [
                    "$value->name",
                    $this->sumProduct(103, "SA", "A", "4", "$length", ["L" => "$value->name"])
                ]
            );
        }
        $arr[++$index] = collect(["Benificiarios que vieram ao Biosp orientados aos seguintes serviços"]);
        foreach (ForwardedService::all() as  $value) {
            $arr[++$index] = collect(
                [
                    "$value->name",
                    $this->sumProduct(103, "SA", "A", "4", "$length", ["P" => "$value->name"])
                ]
            );
            foreach (Genre::all() as $genre) {
                $arr[++$index] = collect(
                    [
                        "   Inclusive do sexo $genre->name",
                        $this->sumProduct(103, "SA", "A", "4", "$length", ["P" => "$value->name", "D" => "$genre->name"])
                    ]
                );
            }
        }
        $arr[++$index] = collect(["Impacto dos benificiarios que se benificiaram  dos seguintes serviços/problema resolvido."]);
        foreach (ForwardedService::all() as  $value) {
            $arr[++$index] = collect(
                [
                    "$value->name",
                    $this->sumProduct(103, "SA", "A", "4", "$length", ["P" => "$value->name", "V" => "Sim"])
                ]
            );
        }

        return collect($arr);
    }
}
