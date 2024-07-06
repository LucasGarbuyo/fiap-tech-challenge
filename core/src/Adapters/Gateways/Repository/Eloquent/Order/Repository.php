<?php

namespace TechChallenge\Adapters\Gateways\Repository\Eloquent\Order;

use TechChallenge\Domain\Order\Repository\IOrder as IOrderRepository;
use TechChallenge\Domain\Order\DAO\IOrder as IOrderDAO;
use TechChallenge\Adapters\Gateways\Repository\Eloquent\Abstract\Repository as AbstractRepository;
use TechChallenge\Domain\Order\Entities\Order as OrderEntity;
use TechChallenge\Domain\Order\SimpleFactory\Order as SimpleFactoryOrder;
use TechChallenge\Adapters\Presenters\Order\ToArray as OrderToArray;

class Repository extends AbstractRepository implements IOrderRepository
{
    private readonly SimpleFactoryOrder $SimpleFactoryOrder;

    private readonly OrderToArray $OrderToArray;

    public function __construct(private readonly IOrderDAO $OrderDAO)
    {
        $this->SimpleFactoryOrder = new SimpleFactoryOrder();

        $this->OrderToArray = new OrderToArray();
    }

    public function index(array $filters = [], array|bool $append = []): array
    {
        return [];
    }

    public function store(OrderEntity $order): void
    {
    }

    public function show(array $filters = [], array|bool $append = []): ?OrderEntity
    {
        return null;
    }

    public function update(OrderEntity $order): void
    {
    }

    public function delete(OrderEntity $order): void
    {
    }

    protected function toEntity(array $data)
    {
    }
}
