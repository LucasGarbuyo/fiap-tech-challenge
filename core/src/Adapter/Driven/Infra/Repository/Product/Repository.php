<?php

namespace TechChallenge\Adapter\Driven\Infra\Repository\Product;

use Illuminate\Support\Facades\DB;
use TechChallenge\Domain\Product\Entities\Product;
use TechChallenge\Domain\Product\Repository\IProduct;

class Repository implements IProduct
{
    /** @return Product[] */
    public function index(array $filters = [], array|bool $append = []): array
    {
        return [];
    }

    public function edit(string $id): Product
    {
        return new Product();
    }

    public function store(Product $product): void
    {
        DB::table('products')->insert([
            'id' => $product->getId(),
            'name' => $product->getName(),
            'description' => $product->getDescription(),
            'price' => $product->getPrice()
        ]);
    }

    public function update(Product $product): void
    {
    }

    public function delete(string $id): void
    {
    }
}
