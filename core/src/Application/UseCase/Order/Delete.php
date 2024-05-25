<?php

namespace TechChallenge\Application\UseCase\Order;

use TechChallenge\Domain\Order\UseCase\Delete as IOrderUseCaseDelete;
use TechChallenge\Domain\Order\UseCase\DtoInput;

class Delete extends IOrderUseCaseDelete
{
    public function execute(DtoInput $data): void
    {
        $order = $this->OrderRepository->show($data->id);

        $order->delete();

        $this->OrderRepository->delete($order);
    }
}
