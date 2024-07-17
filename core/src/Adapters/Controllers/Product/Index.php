<?php

namespace TechChallenge\Adapters\Controllers\Product;

use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Application\UseCase\Product\Index as UseCaseProductIndex;
use TechChallenge\Adapters\Presenters\Product\ToArray as PresenterProductToArray;

final class Index
{
    public function __construct(private readonly AbstractFactoryRepository $AbstractFactoryRepository)
    {
    }

    public function execute(array $filters = [])
    {
        $results = (new UseCaseProductIndex($this->AbstractFactoryRepository))->execute($filters, true);

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
