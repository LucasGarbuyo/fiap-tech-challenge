<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Ramsey\Uuid\Uuid as RamseyUuid;

class OrderItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $orderItems = [];
        
        $orderIds = DB::table('orders')->pluck('id')->toArray();
        $productIds = DB::table('products')->pluck('id')->toArray();
        
        for ($i = 0; $i < 10; $i++) {
            $uuid = RamseyUuid::uuid4();
            $orderItems[] = [
                'id' => $uuid->toString(),
                'order_id' => $faker->randomElement($orderIds),
                'product_id' => $faker->randomElement($productIds),
                'quantity' => $faker->numberBetween(1, 10),
                'price' => $faker->randomFloat(2, 10, 100),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('order_items')->insert($orderItems);
    }
}
