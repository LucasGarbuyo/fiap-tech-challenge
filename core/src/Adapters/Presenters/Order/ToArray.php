<?php

namespace TechChallenge\Adapters\Presenters\Order;

use TechChallenge\Adapters\Presenters\Traits\ExecuteOnArray as ExecuteOnArrayTrait;
use TechChallenge\Domain\Order\Entities\Order as OrderEntity;
use TechChallenge\Domain\Order\Entities\Item as OrderItemEntity;
use TechChallenge\Domain\Order\Entities\Status as OrderStatusEntity;
use TechChallenge\Adapters\Presenters\Customer\ToArray as CustomerToArray;

class ToArray
{
    use ExecuteOnArrayTrait;

    public function execute(OrderEntity $order): array
    {
        return [
            "id" => $order->getId(),
            "customer_id" => $order->getCustomerId(),
            "total" => $order->getTotal() ? $order->getTotal()->getValue() : null,
            "status" => $order->getStatus() ? $order->getStatus()->value : null,
            "customer" => $order->getCustomer() ? (new CustomerToArray())->execute($order->getCustomer()) : [],
            "items" => $this->items($order->getItems()),
            "status_history" => $this->status($order->getStatusHistories()),
            "created_at" => $order->getCreatedAt() ? $order->getCreatedAt()->format("Y-m-d H:i:s") : null,
            "updated_at" => $order->getUpdatedAt() ? $order->getUpdatedAt()->format("Y-m-d H:i:s") : null,
            "deleted_at" => $order->getDeletedAt() ? $order->getDeletedAt()->format("Y-m-d H:i:s") : null,
        ];
    }

    /** @param OrderItemEntity[] $items  */
    protected function items(array $items): array
    {
        $array = [];

        foreach ($items as $item) {
            $array[] = [
                "id" => $item->getId(),
                "order_id" => $item->getOrderId(),
                "product_id" => $item->getProductId(),
                "price" => $item->getPrice() ? $item->getPrice()->getValue() : null,
                "quantity" => $item->getQuantity(),
                "created_at" => $item->getCreatedAt() ? $item->getCreatedAt()->format("Y-m-d H:i:s") : null,
                "updated_at" => $item->getUpdatedAt() ? $item->getUpdatedAt()->format("Y-m-d H:i:s") : null,
                "deleted_at" => $item->getDeletedAt() ? $item->getDeletedAt()->format("Y-m-d H:i:s") : null,
            ];
        }

        return $array;
    }

    /** @param OrderStatusEntity $statusHistories */
    protected function status(array $statusHistories): array
    {
        $status = [];

        foreach ($statusHistories as $statusHistory) {
            $status[] = [
                "id" => $statusHistory->getId(),
                "order_id" => $statusHistory->getOrderId(),
                "status" => $statusHistory->getStatus()->value,
                "created_at" => $statusHistory->getCreatedAt() ? $statusHistory->getCreatedAt()->format("Y-m-d H:i:s") : null,
                "updated_at" => $statusHistory->getUpdatedAt() ? $statusHistory->getUpdatedAt()->format("Y-m-d H:i:s") : null,
                "deleted_at" => $statusHistory->getDeletedAt() ? $statusHistory->getDeletedAt()->format("Y-m-d H:i:s") : null,
            ];
        }

        return $status;
    }
}
