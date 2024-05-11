<?php

namespace TechChallenge\Application\UseCase\Product;

use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;
use TechChallenge\Domain\Product\Entities\Product;

class Store
{
    private IProductRepository $ProductRepository;

    public function __construct(IProductRepository $ProductRepository)
    {
        $this->ProductRepository = $ProductRepository;
    }

    public function execute(Dto $data)
    {
        $product = (new Product())
            ->setId(uniqid("PROD_", true))
            ->setName($data->name)
            ->setDescription($data->description)
            ->setPrice($data->price);

        $this->ProductRepository->store($product);
    }
}
