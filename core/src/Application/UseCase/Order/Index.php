<?php

namespace TechChallenge\Application\UseCase\Order;

use TechChallenge\Domain\Order\UseCase\Index as IOrderUseCaseIndex;

class Index extends IOrderUseCaseIndex
{
    public function execute(array $filters = [], array|bool $append = []): array
    {
        return $this->OrderRepository->index($filters, $append);
    }
}