<?php

namespace Database\Factories;

use App\Models\Address;
use Faker\Factory as FakerFactory;
use Faker\Provider\pt_BR\Person;
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
        $faker = FakerFactory::create();
        $fakerBR = new Person($faker);

        return [
            'name' => $fakerBR->name(),
            'cpf' => $fakerBR->cpf(false),
            'category' => 'Profissional',
            'telephone' => '5522999363638',
            'address_id' => Address::factory(),
        ];
    }
}
