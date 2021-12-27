<?php

namespace App\Http\Resources;

use App\Http\Traits\ArrayToFormattedString;
use Illuminate\Http\Resources\Json\JsonResource;

class BenificiaryResource extends JsonResource
{
    use ArrayToFormattedString;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "Número de Inquérito" => $this->form_number,
            "Nome do participante" => $this->full_name != null ? $this->full_name : "",
            "Idade" => $this->age != null ? $this->age : "",
            "Sexo" => $this->genre != null ? $this->genre->name : "",
            "Qualificação" => $this->qualification != null ? $this->qualification : "",
            "Distrito" => $this->district != null ? $this->district->name : "",
            "Bairro" => $this->zone != null ? $this->zone : "",
            "Localidade" => $this->location != null ? $this->location  : "",
            "Area do projecto" => $this->project_areas->count() > 0 ? $this->convertToString($this->project_areas->pluck('name')): "",
            "Beneficio recebido" => $this->benefits->count()  > 0 ? $this->convertToString($this->benefits->pluck('name')): "",
           ];
    }
}
