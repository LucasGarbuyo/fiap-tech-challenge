<?php

namespace TechChallenge\Application\UseCase\Customer;

use TechChallenge\Domain\Customer\DAO\ICategory as ICustomerDAO;
use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;
use TechChallenge\Domain\Customer\Entities\Customer as CustomerEntity;
use TechChallenge\Domain\Customer\Exceptions\CustomerNotFoundException;

final class Show
{
    public function __construct(
        private readonly ICustomerDAO $CustomerDAO,
        private readonly ICustomerRepository $CustomerRepository
    ) {
    }

    public function execute(string $id): CustomerEntity
    {
        if (!$this->CustomerDAO->exist(["id" => $id]))
            throw new CustomerNotFoundException();

        return $this->CustomerRepository->show(["id" => $id], true);
    }
}
