<?php

namespace TechChallenge\Application\UseCase\Product;

use TechChallenge\Domain\Product\Entities\Product as ProductEntity;
use TechChallenge\Domain\Product\Exceptions\ProductNotFoundException;
use TechChallenge\Domain\Product\UseCase\DtoInput;
use TechChallenge\Domain\Product\UseCase\Show as IProductUseCaseShow;
use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;

class Show implements IProductUseCaseShow
{
    public function __construct(protected readonly IProductRepository $ProductRepository)
    {
    }

    public function execute(DtoInput $data, array|bool $append = []): ProductEntity
    {
        if (!$this->ProductRepository->exist(["id" => $data->id]))
            throw new ProductNotFoundException();

        return $this->ProductRepository->show(["id" => $data->id], $append);
    }
}
