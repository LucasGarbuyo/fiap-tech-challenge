<?php

namespace TechChallenge\Adapters\Controllers\Category;

use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Application\UseCase\Category\Store as UseCaseCategoryStore;
use TechChallenge\Application\DTO\Category\DtoInput as CategoryDtoInput;

final class Store
{
    public function __construct(private readonly AbstractFactoryRepository $AbstractFactoryRepository)
    {
    }

    public function execute(CategoryDtoInput $dto): string
    {
        return (new UseCaseCategoryStore($this->AbstractFactoryRepository))->execute($dto);
    }
}
