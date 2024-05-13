<?php

namespace TechChallenge\Adapter\Driven\Infra\Repository\Product;

use Exception;
use Illuminate\Support\Facades\DB;
use TechChallenge\Domain\Product\Entities\Product;
use TechChallenge\Domain\Product\Repository\IProduct;

class Repository implements IProduct
{
    /** @return Product[] */
    public function index(array $filters = [], array|bool $append = []): array
    {
        $productsData = DB::table('products')->get();

        $products = [];

        foreach ($productsData as $productData)
            $products[] = (new Product)
                ->setId($productData->id)
                ->setName($productData->name)
                ->setDescription($productData->description)
                ->setPrice($productData->price);

        return $products;
    }

    public function edit(string $id): Product
    {
        $productData = DB::table('products')->where('id', $id)->first();

        if (empty($productData))
            throw new Exception("Product not found");

        return (new Product())
            ->setId($productData->id)
            ->setName($productData->name)
            ->setDescription($productData->description)
            ->setPrice($productData->price);
    }

    public function find(string $id): Product|NULL
    {

        // validar erro de id inexistente .
        $getProduct =  DB::table('products')->where('id', $id)->first();

        if (!$getProduct) return NULL;

        $product = optional($getProduct, function ($productData) {
            $product = new Product();
            $product->setId($productData->id);
            $product->setName($productData->name);
            $product->setDescription($productData->description);
            $product->setPrice($productData->price);

            return $product;
        });

        return $product;
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
