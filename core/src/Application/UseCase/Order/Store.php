<?php

namespace TechChallenge\Application\UseCase\Order;

use TechChallenge\Domain\Order\Factories\Order as OrderFactory;
use TechChallenge\Domain\Order\UseCase\DtoInput;
use TechChallenge\Domain\Order\UseCase\Store as IOrderUseCaseStore;

class Store extends IOrderUseCaseStore
{
    public function execute(DtoInput $data): string
    {
        $orderFactory = (new OrderFactory())
            ->new();

        if (!is_null($data->getCustomerId())) {
            $orderFactory->withCustomerId($data->getCustomerId());
        }

        if (!empty($data->getItems())) {
            $orderFactory->withItems($data->getItems());
        }

        $order = $orderFactory->build();

        $this->OrderRepository->store($order);

        return $order->getId();
    }
}
