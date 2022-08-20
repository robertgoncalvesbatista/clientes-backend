<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'rua' => "Rua Domingos Viana",
            'bairro' => "Turf Club",
            'cidade' => "Campos dos Goytacazes",
            'uf' => "RJ",
            'cep' => "28024-140",
            'complemento' => "Escritório",
            'id_customer' => "1",
        ];
    }
}
