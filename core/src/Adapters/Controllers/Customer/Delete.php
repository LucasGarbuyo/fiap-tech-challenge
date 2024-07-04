<?php

namespace TechChallenge\Adapters\Controllers\Customer;

use TechChallenge\Domain\Customer\DAO\ICustomer as ICustomerDAO;
use TechChallenge\Adapters\Gateways\Repository\Customer\Repository as CustomerRepository;
use TechChallenge\Application\UseCase\Customer\Delete as UseCaseCustomerDelete;

final class Delete
{
    public function __construct(private readonly ICustomerDAO $CustomerDAO)
    {
    }

    public function execute(string $id)
    {
        return (new UseCaseCustomerDelete($this->CustomerDAO, (new CustomerRepository($this->CustomerDAO))))->execute($id);
    }
}
