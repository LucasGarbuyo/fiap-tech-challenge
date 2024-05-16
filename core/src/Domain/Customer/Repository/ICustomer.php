<?php

namespace TechChallenge\Domain\Customer\Repository;

use TechChallenge\Domain\Customer\Entities\Customer;

interface ICustomer
{
    /** @return Customer[] */
    public function index(array $filters = [], array|bool $append = []): array;

    public function edit(string $id): Customer;

    public function store(Customer $customer): void;

    public function update(Customer $customer): void;

    public function delete(Customer $customer): void;
}
