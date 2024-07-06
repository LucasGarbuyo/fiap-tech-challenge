<?php

namespace TechChallenge\Domain\Order\Repository;

use TechChallenge\Domain\Order\Entities\Order as OrderEntity;
use TechChallenge\Domain\Order\DAO\IOrder as IOrderDAO;

interface IOrder
{
    public function __construct(IOrderDAO $OrderDAO);

    public function index(array $filters = [], array|bool $append = []): array;

    public function show(array $filters = [], array|bool $append = []): OrderEntity|null;

    public function store(OrderEntity $order): void;

    public function update(OrderEntity $order): void;

    public function delete(OrderEntity $order): void;
}
