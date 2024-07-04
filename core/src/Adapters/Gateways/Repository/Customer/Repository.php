<?php

namespace TechChallenge\Adapters\Gateways\Repository\Customer;

use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;
use TechChallenge\Domain\Customer\DAO\ICustomer as ICustomerDAO;
use TechChallenge\Domain\Customer\Entities\Customer as CustomerEntity;
use TechChallenge\DOmain\CUstomer\Factories\Simple as SimpleFactoryCustomer;
use TechChallenge\Adapters\Presenters\Customer\ToArray as CustomerToArray;

final class Repository implements ICustomerRepository
{
    private readonly SimpleFactoryCustomer $SimpleFactoryCustomer;

    private readonly CustomerToArray $CustomerToArray;

    public function __construct(private readonly ICustomerDAO $CustomerDAO)
    {
        $this->SimpleFactoryCustomer = new SimpleFactoryCustomer();

        $this->CustomerToArray = new CustomerToArray();
    }

    public function index(array $filters = [], array|bool $append = []): array
    {
        $results = $this->CustomerDAO->index($filters, $append);

        if ($this->isPaginated($results))
            $results["data"] = $this->toCustomerEntities($results["data"]);
        else
            $results = $this->toCustomerEntities($results);

        return $results;
    }

    public function store(CustomerEntity $customer): void
    {
        $this->CustomerDAO->store($this->CustomerToArray->execute($customer));
    }

    public function show(array $filters = [], array|bool $append = []): ?CustomerEntity
    {
        $customer = $this->CustomerDAO->show($filters, $append);

        if (is_null($customer))
            return null;

        return $this->toCustomerEntity($customer);
    }

    public function update(CustomerEntity $customer): void
    {
        $this->CustomerDAO->update($this->CustomerToArray->execute($customer));
    }

    public function delete(CustomerEntity $customer): void
    {
        $this->CustomerDAO->delete($this->CustomerToArray->execute($customer));
    }

    private function isPaginated(array $results): bool
    {
        return isset($results["data"]) && isset($results["pagination"]) && count($results["pagination"]) == 6;
    }

    private function toCustomerEntities(array $customers): array
    {
        $customerEntities = [];

        foreach ($customers as $customer)
            $customerEntities[] = $this->toCustomerEntity($customer);

        return $customerEntities;
    }

    private function toCustomerEntity(array $customer): CustomerEntity
    {
        return $this->SimpleFactoryCustomer
            ->new($customer["id"], $customer["created_at"], $customer["updated_at"])
            ->withNameCpfEmail($customer["name"], $customer["cpf"], $customer["email"])
            ->build();
    }
}
