<?php

namespace TechChallenge\Domain\Customer\Repository;

use DateTime;
use TechChallenge\Domain\Customer\Entities\Customer;

interface ICustomer
{
    /** @return Customer[] */
    public function index(array $filters = [], array|bool $append = []): array;

    public function edit(string $id): Customer;

    public function store(Customer $customer): string;

    public function update(Customer $customer): void;

    public function delete(string $id, DateTime $deleteAt): void;
}
