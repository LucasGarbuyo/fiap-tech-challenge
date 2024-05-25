<?php

namespace TechChallenge\Domain\Order\UseCase;

use TechChallenge\Domain\Order\Repository\IOrder as IOrderRepository;

abstract class Standard
{
    protected IOrderRepository $OrderRepository;

    public function __construct(IOrderRepository $OrderRepository)
    {
        $this->OrderRepository = $OrderRepository;
    }
}
