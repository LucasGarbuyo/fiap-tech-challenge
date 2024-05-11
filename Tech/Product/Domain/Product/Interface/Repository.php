<?php

namespace Tech\Product\Domain\Product\Interface;

use Tech\Product\Domain\Product\Entities\Product;

interface Repository
{
    public function create(Product $product);
}
