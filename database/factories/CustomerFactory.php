<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'cpf' => fake()->safeEmail(),
            'category' => fake()->name(),
            'cep' => fake()->name(),
            'address' => fake()->name(),
            'telephone' => fake()->name(),
        ];
    }
}
