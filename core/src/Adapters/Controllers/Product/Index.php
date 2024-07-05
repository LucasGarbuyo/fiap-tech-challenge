<?php

namespace TechChallenge\Adapters\Controllers\Product;

use TechChallenge\Domain\Product\DAO\IProduct as IProductDAO;
use TechChallenge\Adapters\Gateways\Repository\Eloquent\Product\Repository as ProductRepository;
use TechChallenge\Application\UseCase\Product\Index as UseCaseProductIndex;
use TechChallenge\Adapters\Presenters\Product\ToArray as PresenterProductToArray;

final class Index
{
    public function __construct(private readonly IProductDAO $ProductDAO)
    {
    }

    public function execute(array $filters = [])
    {
        $results = (new UseCaseProductIndex((new ProductRepository($this->ProductDAO))))->execute($filters);
        $presenter = new PresenterProductToArray();

        if ($this->isPaginated($results))
            $results["data"] = $presenter->executeOnArray($results["data"]);
        else
            $results = $presenter->executeOnArray($results);

        return $results;
    }

    private function isPaginated(array $results): bool
    {
        return isset($results["data"]) && isset($results["pagination"]) && count($results["pagination"]) == 6;
    }
}
