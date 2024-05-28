<?php

namespace TechChallenge\Domain\Order\UseCase;

use TechChallenge\Domain\Order\Repository\IOrder as IOrderRepository;

interface Delete
{
    public function __construct(IOrderRepository $OrderRepository);

    public function execute(DtoInput $data): void;
}
