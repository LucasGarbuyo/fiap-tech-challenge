<?php

namespace TechChallenge\Adapters\Presenters\Order;

use TechChallenge\Adapters\Presenters\Traits\ExecuteOnArray as ExecuteOnArrayTrait;
use TechChallenge\Domain\Order\Entities\Order as OrderEntity;
use TechChallenge\Adapters\Presenters\Customer\ToArray as CustomerToArray;

class ToArray
{
    use ExecuteOnArrayTrait;

    public function execute(OrderEntity $order): array
    {
        //TODO fazer a parte os appends dos items e status
        return [
            "id" => $order->getId(),
            "customer_id" => $order->getCustomerId(),
            "total" => $order->getTotal() ? $order->getTotal()->getValue() : null,
            "status" => $order->getStatus() ? $order->getStatus()->value : null,
            "customer" => $order->getCustomer() ? (new CustomerToArray())->execute($order->getCustomer()) : [],
            "orders_items" => [], 
            "orders_status" => [], 
            "created_at" => $order->getCreatedAt() ? $order->getCreatedAt()->format("Y-m-d H:i:s") : null,
            "updated_at" => $order->getUpdatedAt() ? $order->getUpdatedAt()->format("Y-m-d H:i:s") : null,
            "deleted_at" => $order->getDeletedAt() ? $order->getDeletedAt()->format("Y-m-d H:i:s") : null,
        ];
    }
}
