<?php

namespace TechChallenge\Application\UseCase\Order;

use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Domain\Order\Repository\IOrder as IOrderRepository;

final class Index
{
    private readonly IOrderRepository $OrderRepository;
    
    public function __construct(AbstractFactoryRepository $AbstractFactoryRepository)
    {
        $this->OrderRepository = $AbstractFactoryRepository->createOrderRepository();
    }

    public function execute(array $filters = [], array|bool $append = []): array
    {
        return $this->OrderRepository->index($filters, $append);
    }
}
