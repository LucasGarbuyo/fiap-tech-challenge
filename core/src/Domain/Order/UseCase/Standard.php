<?php

namespace TechChallenge\Domain\Order\UseCase;

use TechChallenge\Domain\Order\Repository\IOrder as IOrderRepository;

abstract class Standard
{
    protected IOrderRepository $orderRepository;

    public function __construct(IOrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }
}
