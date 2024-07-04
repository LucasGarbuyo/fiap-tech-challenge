<?php

namespace TechChallenge\Adapters\Controllers\Customer;

use TechChallenge\Domain\Customer\DAO\ICustomer as ICustomerDAO;
use TechChallenge\Adapters\Gateways\Repository\Customer\Repository as CustomerRepository;
use TechChallenge\Application\UseCase\Customer\Index as UseCaseCustomerIndex;
use TechChallenge\Adapters\Presenters\Customer\ToArray as PresenterCustomerToArray;

final class Index
{
    public function __construct(private readonly ICustomerDAO $CustomerDAO)
    {
    }

    public function execute(array $filters = [])
    {
        $results = (new UseCaseCustomerIndex((new CustomerRepository($this->CustomerDAO))))->execute($filters);

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
