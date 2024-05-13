<?php

namespace TechChallenge\Adapter\Driver\Controller;

use TechChallenge\Application\UseCase\Product\Dto as ProductDto;
use TechChallenge\Application\UseCase\Product\Store as ProductStore;
use TechChallenge\Application\UseCase\Product\Edit as ProductEdit;
use TechChallenge\Config\Container;

class Product
{
    public function store()
    {
        $data = new ProductDto(null, "Lucas", "teste", 10);

        $productStore = Container::create()->get(ProductStore::class);

        $productStore->execute($data);
    }

    public function edit($id)
    {
        //validar o retorno
        $productEdit =  Container::edit($id)->get(ProductEdit::class);

        dd($productEdit);
    }
}
