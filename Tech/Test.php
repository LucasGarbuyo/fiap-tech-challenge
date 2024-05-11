<?php

namespace Tech;

use Tech\Product\Application\Product\CreateProduct;
use Tech\Product\Application\Product\ProductDto;
use Tech\Product\Infrastructure\Product\Repository as ProductRepository;

class Test
{
    public function test()
    {
        $dados = new ProductDto("Lucas", "simples", 10.50);

        (new teste());

        (new CreateProduct()->exec($dados);
    }
}
