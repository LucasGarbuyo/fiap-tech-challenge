<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Ramsey\Uuid\Uuid as RamseyUuid;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $categories = [];
        $uuid = RamseyUuid::uuid4();


        for ($i = 0; $i < 10; $i++) {
            $categories[] = [
                'id' => "CATE_{$uuid->toString()}",
                'name' => $faker->word,
                'type' => $faker->randomElement(['CAT_1', 'CAT_2', 'CAT_3']),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('categories')->insert($categories);
    }
}
