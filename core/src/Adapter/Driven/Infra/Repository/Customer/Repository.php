<?php

namespace TechChallenge\Adapter\Driven\Infra\Repository\Customer;

use Illuminate\Support\Facades\DB;
use TechChallenge\Domain\Customer\Entities\Customer as CustomerEntity;
use TechChallenge\Domain\Customer\Factories\Customer as CustomerFactory;
use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;
use Illuminate\Database\Query\Builder;
use TechChallenge\Domain\Customer\Exceptions\CustomerNotFoundException;
use TechChallenge\Domain\Customer\ValueObjects\Cpf;

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

    public function show(string $id): CustomerEntity
    {
        $customerData = $this->filters($this->query(), ["id" => $id])->first();

        return (new CustomerFactory())
            ->new($customerData->id, $customerData->created_at, $customerData->updated_at)
            ->withNameCpfEmail($customerData->name, $customerData->cpf, $customerData->email)
            ->build();
    }

    public function editByCpf(Cpf $cpf): CustomerEntity
    {
        $customerData = $this->query()->where('cpf', $cpf)->first();

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
        $this->query()
            ->where('id', $customer->getId())
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

        if (!empty($filters["cpf"])) {
            if (!is_array($filters["cpf"]))
                $filters["cpf"] = [$filters["cpf"]];

            $query->whereIn('cpf', $filters["cpf"]);
        }

        return $query;
    }

    public function query(): Builder
    {
        return DB::table('customers')->whereNull('deleted_at');
    }
}
