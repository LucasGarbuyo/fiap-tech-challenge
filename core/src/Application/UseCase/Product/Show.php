<?php

namespace TechChallenge\Application\UseCase\Product;

use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Domain\Product\DAO\IProduct as IProductDAO;
use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;
use TechChallenge\Domain\Product\Entities\Product as ProductEntity;
use TechChallenge\Domain\Product\Exceptions\ProductNotFoundException;

final class Show
{
    private IProductRepository $ProductRepository;

    private readonly IProductDAO $ProductDAO;

    public function __construct(AbstractFactoryRepository $AbstractFactoryRepository)
    {
        $this->ProductDAO = $AbstractFactoryRepository->getDAO()->createProductDAO();

        $this->ProductRepository = $AbstractFactoryRepository->createProductRepository();
    }

    public function execute(string $id): ProductEntity
    {
        if (!$this->ProductDAO->exist(["id" => $id]))
            throw new ProductNotFoundException();

        return $this->ProductRepository->show(["id" => $id], true);
    }
}
