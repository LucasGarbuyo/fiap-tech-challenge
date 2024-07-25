<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Ramsey\Uuid\Uuid as RamseyUuid;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $products = [];
        $uuid = RamseyUuid::uuid4();

        $categoriesId = DB::table('categories')->pluck('id')->toArray();

        for ($i = 0; $i < 10; $i++) {
            $products[] = [
                'id' => "PROD_{$uuid->toString()}",
                'category_id' => $faker->randomElement($categoriesId),
                'name' => $faker->word,
                'description' => $faker->paragraph,
                'price' => $faker->randomFloat(2, 10, 1000),
                'image' => $faker->imageUrl(640, 480, 'products', true),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('products')->insert($products);
    }
}
