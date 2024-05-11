<?php

namespace TechChallenge\Application\UseCase\Product;

use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;
use TechChallenge\Domain\Product\Entities\Product;

class Create
{
    private IProductRepository $ProductRepository;

    public function __construct(IProductRepository $ProductRepository)
    {
        $this->ProductRepository = $ProductRepository;
    }

    public function execute(Dto $data)
    {
        $product = (new Product())
            ->setId(uniqid(more_entropy: true))
            ->setName($data->name)
            ->setDescription($data->description)
            ->setPrice($data->price);

        $this->ProductRepository->store($product);
    }
}
