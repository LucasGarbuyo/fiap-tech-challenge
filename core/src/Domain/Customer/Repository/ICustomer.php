<?php

namespace TechChallenge\Domain\Customer\Repository;

use TechChallenge\Domain\Customer\Entities\Customer as CustomerEntity;
use TechChallenge\Domain\Customer\DAO\ICustomer as ICustomerDAO;

interface ICustomer
{
    public function __construct(ICustomerDAO $CategoryDAO);

    public function index(array $filters = [], array|bool $append = []): array;

    public function show(array $filters = [], array|bool $append = []): CustomerEntity|null;

    public function store(CustomerEntity $customer): void;

    public function update(CustomerEntity $customer): void;

    public function delete(CustomerEntity $customer): void;
}
