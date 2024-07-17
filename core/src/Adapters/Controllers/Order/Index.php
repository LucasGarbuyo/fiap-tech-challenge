<?php

namespace TechChallenge\Adapters\Controllers\Order;

use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Application\UseCase\Order\Index as UseCaseOrderIndex;
use TechChallenge\Adapters\Presenters\Order\ToArray as PresenterOrderToArray;

final class Index
{
    public function __construct(private readonly AbstractFactoryRepository $AbstractFactoryRepository)
    {
    }

    public function execute(array $filters = [])
    {
        $results = (new UseCaseOrderIndex($this->AbstractFactoryRepository))->execute($filters, true);

        $presenter = new PresenterOrderToArray();

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
