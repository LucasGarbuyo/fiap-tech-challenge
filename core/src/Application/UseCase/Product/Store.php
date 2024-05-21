<?php

namespace TechChallenge\Application\UseCase\Product;

use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;
use TechChallenge\Domain\Product\Factories\Product as ProductFactory;


class Store
{
    private IProductRepository $ProductRepository;

    public function __construct(IProductRepository $ProductRepository)
    {
        $this->ProductRepository = $ProductRepository;
    }

    public function execute(Dto $data)
    {
        $product = (new ProductFactory())
            ->new()
            ->withNameDescriptionPrice($data->name, $data->description, $data->price)
            ->build();

        $this->ProductRepository->store($product);
       
        return $product->getId();
    }
}
