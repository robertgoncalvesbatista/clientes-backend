<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "cep"           => ["required", "string", "max:255"],
            "rua"           => ["required", "string", "max:255"],
            "bairro"        => ["required", "string", "max:255"],
            "cidade"        => ["required", "string", "max:255"],
            "uf"            => ["required", "string", "max:255"],
            "complemento"   => ["required", "string", "max:255"],
        ];
    }
}
