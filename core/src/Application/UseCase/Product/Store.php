<?php

namespace TechChallenge\Application\UseCase\Product;

use DateTime;
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
        $data = (array) $data;

        if (isset($data['id']))
            unset($data['id']);

        $product = (new Product((array) $data))
            ->setId(uniqid("PROD_", true))
            ->setCreatedAt(new DateTime())
            ->setUpdatedAt(new DateTime());

        $this->ProductRepository->store($product);

        return $product->getId();
    }
}
