<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Ramsey\Uuid\Uuid as RamseyUuid;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $customers = [];
        $uuid = RamseyUuid::uuid4();
        
        for ($i = 0; $i < 10; $i++) {
            $customers[] = [
                'id' => "CUST_{$uuid->toString()}",
                'name' => $faker->name,
                'cpf' => $faker->numerify('###########'),
                'email' => $faker->unique()->safeEmail,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('customers')->insert($customers);
    }
}
