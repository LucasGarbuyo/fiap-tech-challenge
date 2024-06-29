<?php

namespace TechChallenge\Adapter\Driven\Infra\Repository\Customer;

use TechChallenge\Domain\Customer\Entities\Customer as CustomerEntity;
use TechChallenge\Domain\Customer\Factories\Customer as CustomerFactory;
use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;

class Repository implements ICustomerRepository
{
    /** @return Customer[] */
    public function index(array $filters = [], array|bool $append = []): array
    {
        $customersData = $this->filters($this->query($append), $filters)->get();

        $customers = [];

        $CustomerFactory = new CustomerFactory();

        foreach ($customersData as $customerData)
            $customers[] = $CustomerFactory
                ->new($customerData->id, $customerData->created_at, $customerData->updated_at)
                ->withNameCpfEmail($customerData->name, $customerData->cpf, $customerData->email)
                ->build();

        return $customers;
    }

    public function show(array $filters = [], array|bool $append = []): CustomerEntity|null
    {
        $customerData = $this->filters($this->query($append), $filters)->first();

        if (empty($customerData))
            return null;

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
        $this->filters($this->query(), ["id" => $customer->getId()])
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
        $this->filters($this->query(), ["id" => $customer->getId()])
            ->update(
                [
                    "deleted_at" => $customer->getDeletedAt()->format("Y-m-d H:i:s")
                ]
            );
    }

    public function exist(array $filters = []): bool
    {
        return $this->filters($this->query(), $filters)->exists();
    }

    public function filters(Builder $query, array $filters = []): Builder
    {
        if (!empty($filters["id"])) {
            if (!is_array($filters["id"]))
                $filters["id"] = [$filters["id"]];

            $query->whereIn('id', $filters["id"]);
        }

        if (!empty($filters["not-id"])) {
            if (!is_array($filters["not-id"]))
                $filters["not-id"] = [$filters["not-id"]];

            $query->whereNotIn('id', $filters["not-id"]);
        }

        if (!empty($filters["cpf"])) {
            if (!is_array($filters["cpf"]))
                $filters["cpf"] = [$filters["cpf"]];

            $query->whereIn('cpf', $filters["cpf"]);
        }

        return $query;
    }

    public function query(array|bool $append = []): Builder
    {
        return DB::table('customers')->whereNull('deleted_at');
    }
}
