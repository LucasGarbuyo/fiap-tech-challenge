<?php

namespace TechChallenge\Adapters\Controllers\Product;

use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Application\DTO\Product\DtoInput as ProductDTOInput;
use TechChallenge\Application\UseCase\Product\Store as UseCaseProductStore;

final class Store
{
    public function __construct(private readonly AbstractFactoryRepository $AbstractFactoryRepository)
    {
    }

    public function execute(ProductDTOInput $dto)
    {
        return (new UseCaseProductStore($this->AbstractFactoryRepository))->execute($dto);
    }
}
