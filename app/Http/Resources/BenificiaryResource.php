<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BenificiaryResource extends JsonResource
{
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
            "Area do projecto" => $this->project_area != null ? $this->project_area->name: "",
            "Beneficio recebido" => $this->benefit  != null ? $this->benefit->name: "",
           ];
    }
}
