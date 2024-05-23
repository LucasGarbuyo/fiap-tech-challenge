<?php

namespace TechChallenge\Domain\Order\Repository;

use TechChallenge\Domain\Order\Entities\Order;

interface IOrder
{
    public function store(Order $order): void;
}
