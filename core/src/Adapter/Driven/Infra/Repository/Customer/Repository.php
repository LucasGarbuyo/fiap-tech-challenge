<?php

namespace TechChallenge\Adapter\Driven\Infra\Repository\Customer;

use DateTime;
use Illuminate\Support\Facades\DB;
use TechChallenge\Domain\Customer\Entities\Customer;
use TechChallenge\Domain\Customer\ValueObjects\Cpf;
use TechChallenge\Domain\Customer\ValueObjects\Email;
use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;
use Illuminate\Database\Query\Builder;

class Repository implements ICustomerRepository
{
    /** @return Customer[] */
    public function index(array $filters = [], array|bool $append = []): array
    {
        $customersData = $this->query()->get();

        $customers = [];

        foreach ($customersData as $customerData)
            $customers[] = (new Customer(
                $customerData->id,
                $customerData->name,
                new Cpf($customerData->cpf),
                new Email($customerData->email)
            ));

        return $customers;
    }

    public function edit(string $id): Customer
    {
        return new Customer();
    }

    public function store(Customer $customer): string
    {
        return "";
    }

    public function update(Customer $customer): void
    {
    }

    public function delete(string $id, DateTime $deleteAt): void
    {
    }

    protected function query(): Builder
    {
        return DB::table('customers')->whereNull('deleted_at');
    }
}
