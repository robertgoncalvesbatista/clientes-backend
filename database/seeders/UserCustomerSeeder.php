<?php

namespace Database\Seeders;

use App\Models\UserCustomer;
use Illuminate\Database\Seeder;

class UserCustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserCustomer::factory()
            ->count(1)
            ->create();
    }
}
