<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use Faker\Provider\pt_BR\Person;
use Faker\Factory as FakerFactory;

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
        $faker = FakerFactory::create();
        $fakerBR = new Person($faker);

        return [
            'name' => $fakerBR->name(),
            'cpf' => $fakerBR->cpf(),
            'cep' => "28024-140",
        ];
    }
}
