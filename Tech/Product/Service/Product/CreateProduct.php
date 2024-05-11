<?php

namespace Tech\Product\Service\Product;

use Tech\Product\Domain\Product\Interface\Repository as ProductRepository;
use Tech\Product\Domain\Product\Entities\Product;

class CreateProduct
{
    private ProductRepository $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function exec(ProductDto $dados): void
    {
        $product = (new Product())
            ->setId(uniqid(more_entropy: true))
            ->setName($dados->name)
            ->setDescription($dados->description)
            ->setPrice($dados->price);

        $this->repository->create($product);
    }
}
