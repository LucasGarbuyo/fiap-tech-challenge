<?php

namespace TechChallenge\Adapters\Controllers\Product;

use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Application\DTO\Product\DtoInput as ProductDTOInput;
use TechChallenge\Application\UseCase\Product\Update as UseCaseProductUpdate;

final class Update
{
    public function __construct(private readonly AbstractFactoryRepository $AbstractFactoryRepository)
    {
    }

    public function execute(ProductDTOInput $dto)
    {
        return (new UseCaseProductUpdate($this->AbstractFactoryRepository))->execute($dto);
    }
}
