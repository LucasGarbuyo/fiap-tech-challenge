<?php

namespace TechChallenge\Adapters\Gateways\Repository\Product;

use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;
use TechChallenge\Domain\Product\DAO\IProduct as IProductDAO;
use TechChallenge\Domain\Customer\Entities\Customer as CustomerEntity;
use TechChallenge\Adapters\Presenters\Customer\ToArray as CustomerToArray;

final class Repository implements IProductRepository
{
    public function __construct(private readonly IProductDAO $CustomerDAO)
    {
    }

    public function index(array $filters = [], array|bool $append = []): array
    {
        dd('parou aqui');
        // return [];
    }

    public function store(CustomerEntity $customer): void
    {
        $array = (new CustomerToArray())->execute($customer);

        $this->CustomerDAO->store($array);
    }

    public function show(array $filters = [], array|bool $append = []): ?CustomerEntity
    {
        return null;
    }

    public function update(CustomerEntity $customer): void
    {
    }

    public function delete(CustomerEntity $customer): void
    {
    }
}
