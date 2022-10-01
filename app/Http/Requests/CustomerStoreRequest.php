<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerStoreRequest extends FormRequest
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
            "name"          => ["required", "string", "max:255"],
            "cpf"           => ["required", "string", "max:255"],
            "category"      => ["required", "string", "max:255"],
            "telephone"     => ["required", "string", "max:255"],
        ];
    }
}
