<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            'id' => $this->id,

            'name' => $this->name,
            'cpf' => $this->cpf,
            'category' => $this->category,
            'telephone' => $this->telephone,

            'rua' => $this->address->rua,
            'bairro' => $this->address->bairro,
            'cidade' => $this->address->cidade,
            'uf' => $this->address->uf,
            'cep' => $this->address->cep,
            'complemento' => $this->address->complemento,
        ];
    }
}
