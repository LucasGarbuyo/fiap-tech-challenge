<?php

namespace TechChallenge\Domain\Order\UseCase;

use TechChallenge\Domain\Order\Repository\IOrder as IOrderRepository;

interface ChangeStatus
{
    public function __construct(IOrderRepository $OrderRepository);

    public function execute(DtoInput $data): void;
}
