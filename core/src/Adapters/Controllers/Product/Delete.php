<?php

namespace TechChallenge\Adapters\Controllers\Product;

use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Application\UseCase\Product\Delete as UseCaseProductDelete;

final class Delete
{
    public function __construct(private readonly AbstractFactoryRepository $AbstractFactoryRepository)
    {
    }

    public function execute(string $id)
    {
        return (new UseCaseProductDelete($this->AbstractFactoryRepository))->execute($id);
    }
}
