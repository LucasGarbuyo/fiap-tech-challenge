<?php

namespace TechChallenge\Adapters\Controllers\Customer;

use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Application\UseCase\Customer\Index as UseCaseCustomerIndex;
use TechChallenge\Adapters\Presenters\Customer\ToArray as PresenterCustomerToArray;

final class Index
{
    public function __construct(private readonly AbstractFactoryRepository $AbstractFactoryRepository)
    {
    }

    public function execute(array $filters = [])
    {
        $results = (new UseCaseCustomerIndex($this->AbstractFactoryRepository))->execute($filters);

        $presenter = new PresenterCustomerToArray();

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
