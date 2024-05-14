<?php

namespace TechChallenge\Domain\Product\Exceptions;

class ProductNotFoundException extends ProductException
{
    public function __construct()
    {
        parent::__construct("Produto não encontrado", 404);
    }
}
