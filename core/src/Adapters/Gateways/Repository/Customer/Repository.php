<?php

namespace TechChallenge\Adapters\Gateways\Repository\Customer;

use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;
use TechChallenge\Domain\Customer\DAO\ICategory as ICategoryDAO;
use TechChallenge\Domain\Customer\Entities\Customer as CustomerEntity;

final class Repository implements ICustomerRepository
{
    public function __construct(private readonly ICategoryDAO $CustomerDAO)
    {
    }

    public function index(array $filters = [], array|bool $append = []): array
    {
    }

    public function store(CustomerEntity $customer): void
    {
    }

    public function show(array $filters = [], array|bool $append = []): ?CustomerEntity
    {
    }

    public function update(CustomerEntity $customer): void
    {
    }

    public function delete(CustomerEntity $customer): void
    {
    }
}
