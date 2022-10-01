<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            "id" => $this->id,
			"rua" => $this->rua,
			"bairro" => $this->bairro,
			"cidade" => $this->cidade,
			"uf" => $this->uf,
			"cep" => $this->cep,
			"complemento" => $this->complemento,
			"id_customer" => $this->id_customer,
        ];
    }
}
