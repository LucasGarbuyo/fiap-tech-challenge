<?php

namespace TechChallenge\Adapter\Driver\Controller;

use Illuminate\Http\Request;
use TechChallenge\Application\UseCase\Product\Dto as ProductDto;
use TechChallenge\Application\UseCase\Product\Store as ProductStore;
use TechChallenge\Application\UseCase\Product\Edit as ProductEdit;
use TechChallenge\Application\UseCase\Product\Index as ProductIndex;
use TechChallenge\Config\Container;

class Product
{
    public function index(Request $request)
    {
        $productIndex = Container::create()->get(ProductIndex::class);

        dd($productIndex->execute());
    }

    public function store(Request $request)
    {
        $data = new ProductDto(null, "Lucas", "teste", 10);

        $productStore = Container::create()->get(ProductStore::class);

        $productStore->execute($data);
    }

    public function edit(Request $request)
    {
        $productEdit = Container::create()->get(ProductEdit::class);

        $data = new ProductDto($request->id);

        $product = $productEdit->execute($data);

        dd($product);
    }
}
