<?php

namespace TechChallenge\Adapters\Controllers\Customer;

use TechChallenge\Domain\Customer\DAO\ICustomer as ICustomerDAO;
use TechChallenge\Application\DTO\Customer\DtoInput as CustomerDTOInput;
use TechChallenge\Adapters\Gateways\Repository\Customer\Repository as CustomerRepository;
use TechChallenge\Application\UseCase\Customer\Store as UseCaseCustomerStore;

final class Store
{
    public function __construct(private readonly ICustomerDAO $CustomerDAO)
    {
    }

    public function execute(CustomerDTOInput $dto): string
    {
        return (new UseCaseCustomerStore($this->CustomerDAO, (new CustomerRepository($this->CustomerDAO))))->execute($dto);
    }
}
