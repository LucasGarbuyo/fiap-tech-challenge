<?php

namespace TechChallenge\Domain\Order\Repository;

use TechChallenge\Domain\Order\Entities\Order;

interface IOrder
{
    /** @return Order[] */
    public function index(array $filters = [], array|bool $append = []): array;

    public function store(Order $order): void;
}
