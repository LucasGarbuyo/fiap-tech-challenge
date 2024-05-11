<?php

namespace TechChallenge\Adapter\Driver\Controller;

use TechChallenge\Application\UseCase\Product\Dto as ProductDto;
use TechChallenge\Application\UseCase\Product\Store as ProductStore;
use TechChallenge\Adapter\Driven\Infra\Repository\Product\Repository as ProductRepository;

class Product
{
    public function store()
    {
        $data = new ProductDto(null, "Lucas", "teste", 10);

        (new ProductStore(new ProductRepository()))->execute($data);
    }
}
