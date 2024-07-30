<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

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

        // Obter categorias do banco de dados
        $categories = DB::table('categories')->pluck('id', 'name')->toArray();

        // Definir produtos com suas respectivas categorias
        $foodNames = [
            'Hambúrguer' => ['X-Salada', 'Xis-Bacon', 'X-Coração', 'X-Frango', 'X-Bacon', 'X-Calabresa', 'X Calabresa'],
            'Sanduíches' => ['Bauru de Filé', 'Bauru de Filé ao Molho 4 Queijos', 'Bauru de Filé ao Molho Branco', 'Sanduíche Simples', 'Bauru Lombinho com Abacaxi'],
            'Vegetariano' => ['X-Burger Vegetariano'],
            'Frango' => ['Hamburguer de Frango', 'Hamburguer de Frango com Bacon', 'Hamburguer de Frango com Calabresa', 'Hamburguer de Frango com Cheddar'],
            'Carnes' => ['X-Salada', 'Xis-Bacon', 'Hamburguer de Picanha', 'Hamburguer de Picanha com Bacon', 'Hamburguer Duplo'],
            'Acompanhamentos' => ['Onion Rings', 'Batata Frita', 'Batata Frita com Cheddar', 'Batata Frita com Cheddar e Bacon'],
            'Bebidas' => ['Coca-Cola Lata', 'Coca-Cola 600ml', 'Coca-Cola 2L', 'Coca-Cola Lata Zero', 'Fanta Lata', 'Fanta 600ml', 'Fanta 2L', 'Fanta Lata Zero', 'Sprite Lata', 'Sprite 600ml', 'Sprite 2L', 'Sprite Lata Zero', 'Água sem gás', 'Água com gás', 'Suco de Uva', 'Suco de Abacaxi', 'Suco de Laranja', 'Suco de Limão', 'Suco de Morango'],
        ];

        $products = [];
        foreach ($foodNames as $categoryName => $items) {
            if (!isset($categories[$categoryName])) {
                continue;
            }
            $categoryId = $categories[$categoryName];
            foreach ($items as $item) {
                $products[] = [
                    'id' => "PROD_{$faker->uuid()}",
                    'category_id' => $categoryId,
                    'name' => $item,
                    'description' => $faker->paragraph,
                    'price' => $faker->randomFloat(2, 10, 1000),
                    'image' => $faker->imageUrl(640, 480, 'products', true),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('products')->insert($products);
    }
}
