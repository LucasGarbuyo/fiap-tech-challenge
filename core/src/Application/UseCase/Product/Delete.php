<?php

namespace TechChallenge\Application\UseCase\Product;

use TechChallenge\Domain\Product\DAO\IProduct as IProductDAO;
use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;
use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Domain\Product\Exceptions\ProductNotFoundException;

final class Delete
{
    private IProductRepository $ProductRepository;

    private readonly IProductDAO $ProductDAO;

    public function __construct(AbstractFactoryRepository $AbstractFactoryRepository)
    {
        $this->ProductDAO = $AbstractFactoryRepository->getDAO()->createProductDAO();

        $this->ProductRepository = $AbstractFactoryRepository->createProductRepository();
    }

    public function execute(string $id): void
    {
        if (!$this->ProductDAO->exist(["id" => $id]))
            throw new ProductNotFoundException();

        $product = $this->ProductRepository->show(["id" => $id]);

        $product->delete();

        $this->ProductRepository->delete($product);
    }
}
