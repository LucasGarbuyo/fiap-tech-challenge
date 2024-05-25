<?php

namespace TechChallenge\Application\UseCase\Order;

use TechChallenge\Domain\Order\UseCase\Index as OrderUseCaseIndex;

class Index extends OrderUseCaseIndex
{
    public function execute(array $filters = [], array|bool $append = []): array
    {
        return $this->orderRepository->index($filters, $append);
    }
}


/*
class Index extends IProductUseCaseIndex
{
    public function execute(array $filters = [], array|bool $append = []): array
    {
        return $this->ProductRepository->index($filters, $append);
    }
}


*/