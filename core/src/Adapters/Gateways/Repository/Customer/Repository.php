<?php

namespace TechChallenge\Adapters\Gateways\Repository\Customer;

use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;
use TechChallenge\Domain\Customer\DAO\ICustomer as ICustomerDAO;
use TechChallenge\Domain\Customer\Entities\Customer as CustomerEntity;
use TechChallenge\Adapters\Presenters\Customer\ToArray as CustomerToArray;

final class Repository implements ICustomerRepository
{
    public function __construct(private readonly ICustomerDAO $CustomerDAO)
    {
    }

    public function index(array $filters = [], array|bool $append = []): array
    {
        return [];
    }

    public function store(CustomerEntity $customer): void
    {
        $array = (new CustomerToArray())->execute($customer);

        $this->CustomerDAO->store($array);
    }

    public function show(array $filters = [], array|bool $append = []): ?CustomerEntity
    {
        return null;
    }

    public function update(CustomerEntity $customer): void
    {
    }

    public function delete(CustomerEntity $customer): void
    {
    }
}
