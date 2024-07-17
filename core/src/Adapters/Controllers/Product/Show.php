<?php

namespace TechChallenge\Adapters\Controllers\Product;

use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Application\UseCase\Product\Show as UseCaseProductShow;
use TechChallenge\Adapters\Presenters\Product\ToArray as PresenterProductToArray;

final class Show
{
    public function __construct(private readonly AbstractFactoryRepository $AbstractFactoryRepository)
    {
    }

    public function execute(string $id)
    {
        $product = (new UseCaseProductShow($this->AbstractFactoryRepository))->execute($id);

        return (new PresenterProductToArray())->execute($product);
    }
}
