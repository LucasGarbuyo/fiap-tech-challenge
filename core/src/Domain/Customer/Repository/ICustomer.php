<?php

namespace TechChallenge\Domain\Customer\Repository;

use TechChallenge\Domain\Customer\Entities\Customer;

interface ICustomer
{
    /** @return Customer[] */
    public function index(array $filters = [], array|bool $append = []): array;

    public function show(array $filters = [], array|bool $append = []): Customer|null;

    public function store(Customer $customer): void;

    public function update(Customer $customer): void;

    public function delete(Customer $customer): void;

    public function exist(array $filters = []): bool;
}
