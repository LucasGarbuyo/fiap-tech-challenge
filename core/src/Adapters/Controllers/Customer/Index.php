<?php

namespace TechChallenge\Adaptes\Controllers\Customer;

use TechChallenge\Domain\Customer\DAO\ICategory as ICategoryDAO;
use TechChallenge\Adapters\Gateways\Repository\Customer\Repository as CustomerRepository;
use TechChallenge\Application\UseCase\Customer\Index as UseCaseCustomerIndex;

final class Index
{
    public function __construct(private readonly ICategoryDAO $CategoryDAO)
    {
    }

    public function execute(array $filters = [])
    {
        $categories = (new UseCaseCustomerIndex((new CustomerRepository($this->CategoryDAO))))->execute($filters);
    }

    protected function isPaginated(): bool
    {
    }
}
