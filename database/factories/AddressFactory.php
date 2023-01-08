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
            'rua' => $this->faker->streetName,
            'bairro' => $this->faker->streetAddress,
            'cidade' => $this->faker->city,
            'uf' => 'RJ',
            'cep' => '28024140',
            'complemento' => 'Escritório',
        ];
    }
}
