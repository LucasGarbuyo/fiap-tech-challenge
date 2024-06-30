<?php

namespace TechChallenge\Infra\DB\Eloquent\Customer;

use TechChallenge\Domain\Customer\DAO\ICustomer as ICustomerDAO;

final class DAO implements ICustomerDAO
{
    public function index(array $filters = [], array|bool $append = []): array
    {
        $query = Model::query();
    }

    public function store(array $category): void
    {
    }

    public function show(array $filters = [], array|bool $append = []): ?array
    {
    }

    public function update(array $category): void
    {
    }

    public function delete(array $category): void
    {
    }

    public function exist(array $filters = []): bool
    {
    }
}
