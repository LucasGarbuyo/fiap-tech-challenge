<?php

namespace TechChallenge\Domain\Order\UseCase;

use TechChallenge\Domain\Order\Repository\IOrder as IOrderRepository;

interface Index
{
    public function __construct(IOrderRepository $OrderRepository);

    public function execute(array $filters = [], array|bool $append = []): array;
}
