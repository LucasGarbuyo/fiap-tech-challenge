<?php

namespace TechChallenge\Domain\Customer\Repository;

use TechChallenge\Domain\Customer\Entities\Customer;
use TechChallenge\Domain\Customer\ValueObjects\Cpf;

interface ICustomer
{
    /** @return Customer[] */
    public function index(array $filters = [], array|bool $append = []): array;

    public function show(string $id): Customer;

    public function store(Customer $customer): void;

    public function update(Customer $customer): void;

    public function delete(Customer $customer): void;

    public function editByCpf(Cpf $cpf): Customer;

    public function exist(array $filters = []): bool;
}
