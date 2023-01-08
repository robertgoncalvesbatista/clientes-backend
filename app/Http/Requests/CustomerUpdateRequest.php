<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerUpdateRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'cpf' => ['required', 'string', 'max:11', Rule::unique('customers', 'cpf')->ignore($this->customer, 'id')],
            'category' => ['required', 'string', 'max:255'],
            'telephone' => ['required', 'string', 'max:13'],

            'cep' => ['required', 'string', 'max:8'],
            'rua' => ['required', 'string', 'max:255'],
            'bairro' => ['required', 'string', 'max:255'],
            'cidade' => ['required', 'string', 'max:255'],
            'uf' => ['required', 'string', 'max:255'],
            'complemento' => ['required', 'string', 'max:255'],
        ];
    }
}
