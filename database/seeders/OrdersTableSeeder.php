<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Ramsey\Uuid\Uuid as RamseyUuid;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $orders = [];
        
        $customerIds = DB::table('customers')->pluck('id')->toArray();
        
        for ($i = 0; $i < 10; $i++) {
            $uuid = RamseyUuid::uuid4();
            $orders[] = [
                'id' => "ORDE_{$uuid->toString()}",
                'customer_id' => $faker->randomElement($customerIds),
                'total' => $faker->randomFloat(2, 10, 1000),
                'status' => $faker->randomElement([
                    'NEW',
                    'RECEIVED',
                    'PAID',
                    'IN_PREPARATION',
                    'READY',
                    'FINISHED',
                    'CANCELED',
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('orders')->insert($orders);
    }
}
