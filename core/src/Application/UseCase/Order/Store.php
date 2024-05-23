<?php

namespace TechChallenge\Application\UseCase\Order;

use TechChallenge\Domain\Order\Factories\Order as OrderFactory;
use TechChallenge\Domain\Order\UseCase\DtoInput;
use TechChallenge\Domain\Order\UseCase\Store as IOrderUseCaseStore;

class Store extends IOrderUseCaseStore
{
    public function execute(DtoInput $data): string
    {
        $order = (new OrderFactory())
            ->new()
            ->withCustomerIdItems($data->customerId, $data->items)
            ->build();

        $this->orderRepository->store($order);

        return $order->getId();
    }
}
