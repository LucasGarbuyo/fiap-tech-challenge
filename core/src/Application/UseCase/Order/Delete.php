<?php

namespace TechChallenge\Application\UseCase\Order;

use TechChallenge\Domain\Order\UseCase\Delete as IOrderUseCaseDelete;
use TechChallenge\Domain\Order\UseCase\DtoInput;
use TechChallenge\Domain\Order\Repository\IOrder as IOrderRepository;

class Delete implements IOrderUseCaseDelete
{
    public function __construct(protected readonly IOrderRepository $OrderRepository)
    {
    }

    public function execute(DtoInput $data): void
    {
        $order = $this->OrderRepository->show($data->id);

        $order->delete();

        $this->OrderRepository->delete($order);
    }
}
