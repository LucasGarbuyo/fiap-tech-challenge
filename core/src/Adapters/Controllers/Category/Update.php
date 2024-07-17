<?php

namespace TechChallenge\Adapters\Controllers\Category;

use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Application\UseCase\Category\Update as UseCaseCategoryUpdate;
use TechChallenge\Application\DTO\Category\DtoInput as CategoryDtoInput;

final class Update
{
    public function __construct(private readonly AbstractFactoryRepository $AbstractFactoryRepository)
    {
    }

    public function execute(CategoryDtoInput $dto)
    {
        return (new UseCaseCategoryUpdate($this->AbstractFactoryRepository))->execute($dto);
    }
}
