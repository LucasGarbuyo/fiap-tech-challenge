<?php

namespace TechChallenge\Adaptes\Controllers\Customer;

use TechChallenge\Domain\Customer\DAO\ICategory as ICategoryDAO;
use TechChallenge\Adapters\Gateways\Repository\Customer\Repository as CustomerRepository;
use TechChallenge\Application\UseCase\Customer\Delete as UseCaseCustomerDelete;

final class Delete
{
    public function __construct(private readonly ICategoryDAO $CategoryDAO)
    {
    }

    public function execute(string $id)
    {
        return (new UseCaseCustomerDelete($this->CategoryDAO, (new CustomerRepository($this->CategoryDAO))))->execute($id);
    }
}
