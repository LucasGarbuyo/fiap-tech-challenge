<?php

namespace TechChallenge\Domain\OrderItem\UseCase;

use TechChallenge\Domain\Order\Repository\IItem as IItemRepository;

abstract class Standard
{
    protected IItemRepository $OrderItemRepository;

    public function __construct(IItemRepository $OrderItemRepository)
    {
        $this->OrderItemRepository = $OrderItemRepository;
    }
}
