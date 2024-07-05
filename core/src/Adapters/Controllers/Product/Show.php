<?php

namespace TechChallenge\Adapters\Controllers\Product;

use TechChallenge\Domain\Product\DAO\IProduct as IProductDAO;
use TechChallenge\Adapters\Gateways\Repository\Eloquent\Product\Repository as ProductRepository;
use TechChallenge\Application\UseCase\Product\Show as UseCaseProducShow;
use TechChallenge\Adapters\Presenters\Product\ToArray as PresenterProductToArray;

final class Show
{
    public function __construct(private readonly IProductDAO $IProductDAO)
    {
    }

    public function execute(string $id): array
    {
        $product = (new UseCaseProducShow($this->IProductDAO, (new ProductRepository($this->IProductDAO))))->execute($id);

        return (new PresenterProductToArray())->execute($product);
    }
}
