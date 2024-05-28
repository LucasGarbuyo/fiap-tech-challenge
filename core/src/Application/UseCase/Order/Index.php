<?php

namespace TechChallenge\Application\UseCase\Order;

use TechChallenge\Domain\Order\UseCase\Index as IOrderUseCaseIndex;
use TechChallenge\Domain\Order\Repository\IOrder as IOrderRepository;

class Index implements IOrderUseCaseIndex
{
    public function __construct(protected readonly IOrderRepository $OrderRepository)
    {
    }

    public function execute(array $filters = [], array|bool $append = []): array
    {
        return $this->OrderRepository->index($filters, $append);
    }
}
