<?php

namespace TechChallenge\Adapters\Presenters\Product;

use TechChallenge\Domain\Product\Entities\Product as ProductEntity;

class ToJson
{
    public function executeOnArray(array $entities): string
    {
        return json_encode((new ToArray())->executeOnArray($entities));
    }

    public function execute(ProductEntity $product): string
    {
        return json_encode((new ToArray())->execute($product));
    }
}
