<?php

namespace Tech\Product\Infrastructure\Product;

use Illuminate\Support\Facades\DB;
use Tech\Product\Domain\Product\Entities\Product;
use Tech\Product\Domain\Product\Interface\Repository as IProductRepository;

class Repository implements IProductRepository
{
    public function create(Product $product)
    {
        DB::table('products')->insert([
            'id' => $product->getId(),
            'name' => $product->getName(),
            'description' => $product->getDescription(),
            'price' => $product->getPrice()
        ]);
    }
}
