<?php

namespace TechChallenge\Adapters\Controllers\Customer;

use TechChallenge\Domain\Customer\DAO\ICustomer as ICustomerDAO;
use TechChallenge\Adapters\Gateways\Repository\Customer\Repository as CustomerRepository;
use TechChallenge\Application\UseCase\Customer\Index as UseCaseCustomerIndex;

final class Index
{
    public function __construct(private readonly ICustomerDAO $CustomerDAO)
    {
    }

    public function execute(array $filters = [])
    {
        $categories = (new UseCaseCustomerIndex((new CustomerRepository($this->CustomerDAO))))->execute($filters);
    }

    protected function isPaginated(): bool
    {
    }
}
