<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CustomersTableSeeder::class,
            CategoriesTableSeeder::class,
            ProductsTableSeeder::class,
            OrdersTableSeeder::class,
            OrderItemsTableSeeder::class,
            OrderStatusTableSeeder::class,
        ]);
    }
}
