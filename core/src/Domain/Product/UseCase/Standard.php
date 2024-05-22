<?php

namespace TechChallenge\Domain\Product\UseCase;

use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;

abstract class Standard
{
    protected IProductRepository $ProductRepository;

    public function __construct(IProductRepository $ProductRepository)
    {
        $this->ProductRepository = $ProductRepository;
    }
}
