<?php

namespace TechChallenge\Adapters\Gateways\Repository\Eloquent\Customer;

use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;
use TechChallenge\Domain\Customer\DAO\ICustomer as ICustomerDAO;
use TechChallenge\Domain\Customer\Entities\Customer as CustomerEntity;
use TechChallenge\Domain\Customer\SimpleFactory\Customer as SimpleFactoryCustomer;
use TechChallenge\Adapters\Presenters\Customer\ToArray as CustomerToArray;
use TechChallenge\Adapters\Gateways\Repository\Eloquent\Abstract\Repository as AbstractRepository;

final class Repository extends AbstractRepository implements ICustomerRepository
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
            $results["data"] = $this->toEntities($results["data"]);
        else
            $results = $this->toEntities($results);

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

        return $this->toEntity($customer);
    }

    public function update(CustomerEntity $customer): void
    {
        $this->CustomerDAO->update($this->CustomerToArray->execute($customer));
    }

    public function delete(CustomerEntity $customer): void
    {
        $this->CustomerDAO->delete($this->CustomerToArray->execute($customer));
    }

    protected function toEntity(array $customer): CustomerEntity
    {
        return $this->SimpleFactoryCustomer
            ->new($customer["id"], $customer["created_at"], $customer["updated_at"])
            ->withNameCpfEmail($customer["name"], $customer["cpf"], $customer["email"])
            ->build();
    }
}
