<?php

namespace TechChallenge\Application\UseCase\Product;

use TechChallenge\Domain\Product\Exceptions\ProductNotFoundException;
use TechChallenge\Domain\Product\UseCase\Delete as IProductUseCaseDelete;
use TechChallenge\Domain\Product\UseCase\DtoInput;
use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;

class Delete implements IProductUseCaseDelete
{
    public function __construct(protected readonly IProductRepository $ProductRepository)
    {
    }

    public function execute(DtoInput $data): void
    {
        if (!$this->ProductRepository->exist(["id" => $data->id]))
            throw new ProductNotFoundException();

        $product = $this->ProductRepository->show(["id" => $data->id]);

        $product->delete();

        $this->ProductRepository->delete($product);
    }
}
