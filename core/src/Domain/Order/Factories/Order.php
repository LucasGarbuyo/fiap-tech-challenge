<?php

namespace TechChallenge\Domain\Order\Factories;

use DateTime;
use TechChallenge\Domain\Order\Entities\Order as OrderEntity;

class Order
{
    private OrderEntity $order;

    public function new(?string $id = null, String|DateTime $created_at = null, String|DateTime $updated_at = null): self
    {
        if (!is_null($created_at)) {
            $created_at = is_string($created_at) ? new DateTime($created_at) : $created_at;
        }

        if (!is_null($updated_at)) {
            $updated_at = is_string($updated_at) ? new DateTime($updated_at) : $updated_at;
        }

        $this->order = OrderEntity::create($id, $created_at, $updated_at);

        return $this;
    }

    public function withCustomerIdItems(string $customerId, array $items): self
    {
        $this->order
            ->setCustomerId($customerId);

        foreach ($items as $item) {
            $this->order->setItem($item['productId'], $item['quantity']);
        }
        return $this;
    }

    public function build(): OrderEntity
    {
        return $this->order;
    }
}
