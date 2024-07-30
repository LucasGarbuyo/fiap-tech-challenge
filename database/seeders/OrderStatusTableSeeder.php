<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Ramsey\Uuid\Uuid as RamseyUuid;

class OrderStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $orderStatuses = [];
        
        $orderIds = DB::table('orders')->pluck('id')->toArray();
        
        for ($i = 0; $i < 10; $i++) {
            $uuid = RamseyUuid::uuid4();
            $orderStatuses[] = [
                'id' => $uuid->toString(),
                'order_id' => $faker->randomElement($orderIds),
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

        DB::table('order_status')->insert($orderStatuses);
    }
}
