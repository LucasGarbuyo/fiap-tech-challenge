<?php

namespace TechChallenge\Adapter\Driver\Controller;

use TechChallenge\Application\UseCase\Product\Dto as ProductDto;
use TechChallenge\Application\UseCase\Product\Store as ProductStore;
use TechChallenge\Config\Container;

class Product
{
    public function store()
    {
        $data = new ProductDto(null, "Lucas", "teste", 10);

        $productStore = Container::create()->get(ProductStore::class);

        $productStore->execute($data);
    }
}
