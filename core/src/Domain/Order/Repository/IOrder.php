<?php

namespace TechChallenge\Domain\Order\Repository;

use TechChallenge\Domain\Order\Entities\Order;

interface IOrder
{
    /** @return Order[] */
    public function index(array $filters = [], array|bool $append = []): array;

    public function show(array $filters = [], array|bool $append = []): Order|null;

    public function store(Order $order): void;

    public function update(Order $order): void;

    public function delete(Order $order): void;

    public function exist(array $filters = []): bool;
}
