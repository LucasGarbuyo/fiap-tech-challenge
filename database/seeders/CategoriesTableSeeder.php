<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

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

        $categoriesNames = [
            'Hambúrguer',
            'Sanduíches',
            'Vegetariano',
            'Frango',
            'Carnes',
            'Acompanhamentos',
            'Bebidas',
        ];

        $categories = [];
        foreach ($categoriesNames as $categoryName) {
            $categories[] = [
                'id' => "CATE_{$faker->uuid()}",
                'name' => $categoryName,
                'type' => $faker->randomElement(['CAT_1', 'CAT_2', 'CAT_3']),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('categories')->insert($categories);
    }
}
