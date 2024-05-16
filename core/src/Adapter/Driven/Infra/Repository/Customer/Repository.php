<?php

namespace TechChallenge\Adapter\Driven\Infra\Repository\Customer;

use Illuminate\Support\Facades\DB;
use TechChallenge\Domain\Customer\Entities\Customer as CustomerEntity;
use TechChallenge\Domain\Customer\Factories\Customer as CustomerFactory;
use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;
use Illuminate\Database\Query\Builder;
use TechChallenge\Domain\Customer\Exceptions\CustomerNotFoundException;

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

    public function edit(string $id): CustomerEntity
    {
        $customerData = $this->query()->where('id', $id)->first();

        if (empty($customerData))
            throw new CustomerNotFoundException();

        return (new CustomerFactory())
            ->new($customerData->id, $customerData->created_at, $customerData->updated_at)
            ->withNameCpfEmail($customerData->name, $customerData->cpf, $customerData->email)
            ->build();
    }

    public function store(CustomerEntity $customer): void
    {
        $this->query()
            ->insert([
                "id" => $customer->getId(),
                "name" => $customer->getName(),
                "cpf" => $customer->getCpf(),
                "email" => $customer->getEmail(),
                "created_at" => $customer->getCreatedAt(),
                "updated_at" => $customer->getUpdatedAt(),
            ]);
    }

    public function update(CustomerEntity $customer): void
    {
        if (!$this->query()->where('id', $customer->getId())->exists())
            throw new CustomerNotFoundException();

        $this->query()
            ->where('id', $customer->getId())
            ->update(
                [
                    "name" => $customer->getName(),
                    "cpf" => $customer->getCpf(),
                    "email" => $customer->getEmail(),
                    "created_at" => $customer->getCreatedAt(),
                    "updated_at" => $customer->getUpdatedAt()
                ]
            );
    }

    public function delete(CustomerEntity $customer): void
    {
        $this->query()
            ->where('id', $customer->getId())
            ->update(
                [
                    "deleted_at" => $customer->getDeletedAt()->format("Y-m-d H:i:s")
                ]
            );
    }

    protected function query(): Builder
    {
        return DB::table('customers')->whereNull('deleted_at');
    }
}
