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
            "uuid" => $this->uuid,
            "Nome Completo" => $this->full_name != null ? $this->full_name : "",
            "Bairro" => $this->neighborhood != null ? $this->neighborhood->name : "",
            "Sexo" => $this->genre != null ? $this->genre->name : "",
            "1° visita ou Frequência" => $this->number_of_visits != null ? $this->number_of_visits : "",
            "Proveniência" => $this->provenace != null ? $this->provenace->name : "",
            "Data de Nascimento" => $this->birth_date != null ? date_format($this->birth_date, "m/d/y h:m:s") : "",
            "Contacto" => $this->phone != null ? $this->phone : "",
            "Data de Atendimento" => $this->service_date != null ? date_format($this->service_date, "m/d/y h:m:s"): "",
            "Objectivo da Visita" => $this->purpose_of_visit  != null ? $this->purpose_of_visit->name: "",
            "Especificar objectivo da visita " => $this->specify_purpose_of_visit   != null ? $this->specify_purpose_of_visit : "",
            "Motivo de Abertura do Processo" => $this->reason_opening_case  != null ? $this->reason_opening_case->name: "",
            "Outro motivo de Abertura do Processo" => $this->other_reason_opening_case   != null ? $this->other_reason_opening_case: "",
            "Documentos necessários" => $this->document_type  != null ?$this->document_type->name: "",
            "Outros documentos necessários" => $this->other_document_type   != null ?$this->other_document_type: "",
            "Serviço Encaminhado" => $this->forwarded_service  != null ?$this->forwarded_service->name: "",
            "Outro serviço Encaminhado" => $this->other_forwarded_service  != null ?$this->other_forwarded_service: "",
            "Especificar serviço ecaminhado" => $this->specify_forwarded_service  != null ? $this->specify_forwarded_service : "",
            "Necessidade de Acompanhamento Domiciliar" => ( $this->home_care ?"Sim":"Não"),
            "Objectivos da(s) visitas" => $this->visit_proposes  != null  ?$this->visit_proposes: "",
            "Data em que foi recebida pelo serviço" => $this->date_received  != null ?date_format($this->date_received, "m/d/y h:m:s"): "",
            "Resolveu o seu Problema?" => ( $this->status == true ?"Sim":"Não"),
            "Data da criação do registo" => $this->created_at   != null ?date_format($this->created_at, "m/d/y h:m:s"): "",
            "Data da actualização do registo" => $this->updated_at   != null ?date_format($this->updated_at, "m/d/y h:m:s"): "",
        ];
    }
}
