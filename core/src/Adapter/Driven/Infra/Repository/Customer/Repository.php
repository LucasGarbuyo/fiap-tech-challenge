<?php

namespace TechChallenge\Adapter\Driven\Infra\Repository\Customer;

use DateTime;
use Illuminate\Support\Facades\DB;
use TechChallenge\Domain\Customer\Entities\Customer;
use TechChallenge\Domain\Customer\Factories\Customer as CustomerFactory;
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

        $CustomerFactory = new CustomerFactory();

        foreach ($customersData as $customerData)
            $customers[] = $CustomerFactory
                ->new($customerData->id, $customerData->created_at, $customerData->updated_at)
                ->withNameCpfEmail($customerData->name, $customerData->cpf, $customerData->email)
                ->build();

        return $customers;
    }

    public function edit(string $id): Customer
    {
        return new Customer();
    }

    public function store(Customer $customer): void
    {
        $this->query()->insert([
            "id" => $customer->getId(),
            "name" => $customer->getName(),
            "cpf" => $customer->getCpf(),
            "email" => $customer->getEmail(),
            "created_at" => $customer->getCreatedAt(),
            "updated_at" => $customer->getUpdatedAt(),
        ]);
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
