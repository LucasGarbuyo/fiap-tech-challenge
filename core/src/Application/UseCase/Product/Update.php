<?php

namespace TechChallenge\Application\UseCase\Product;

use DateTime;
use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;
use TechChallenge\Domain\Product\Entities\Product;

class Update
{
    private IProductRepository $ProductRepository;

    public function __construct(IProductRepository $ProductRepository)
    {
        $this->ProductRepository = $ProductRepository;
    }

    public function execute(Dto $data)
    {
        $data = (array) $data;

        $product = (new Product((array) $data))
            ->setUpdatedAt(new DateTime());

        return $this->ProductRepository->update($product);
    }
}
