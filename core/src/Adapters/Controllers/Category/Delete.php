<?php

namespace TechChallenge\Adapters\Controllers\Category;

use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Application\UseCase\Category\Delete as UseCaseCategoryDelete;

final class Delete
{
    public function __construct(private readonly AbstractFactoryRepository $AbstractFactoryRepository)
    {
    }

    public function execute(string $id)
    {
        return (new UseCaseCategoryDelete($this->AbstractFactoryRepository))->execute($id);
    }
}
