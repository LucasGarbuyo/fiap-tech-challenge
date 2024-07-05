<?php

namespace TechChallenge\Application\UseCase\Product;

use TechChallenge\Domain\Product\DAO\IProduct as IProductDAO;
use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;
use TechChallenge\Domain\Product\Entities\Product as ProductEntity;
use TechChallenge\Domain\Product\Exceptions\ProductNotFoundException;

class Show
{

    public function __construct(
        private readonly IProductDAO $ProductDAO,
        private readonly IProductRepository $ProductRepository
    ) {
    }

    public function execute(string $id): ProductEntity
    {
        if (!$this->ProductDAO->exist(["id" => $id]))
            throw new ProductNotFoundException();

        return $this->ProductRepository->show(["id" => $id], true);
    }
}
