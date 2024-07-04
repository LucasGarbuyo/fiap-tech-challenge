<?php

namespace TechChallenge\Adapters\Presenters\Product;

use TechChallenge\Adapters\Presenters\Traits\ExecuteOnArray as ExecuteOnArrayTrait;
use TechChallenge\Domain\Product\Entities\Product as ProductEntity;

class ToArray
{
    use ExecuteOnArrayTrait;

    public function execute(ProductEntity $product): array
    {
        return $product->toArray();
    }
}
