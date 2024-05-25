<?php

namespace TechChallenge\Domain\Order\Factories;

use DateTime;
use TechChallenge\Domain\Order\Entities\Item;
use TechChallenge\Domain\Order\Entities\Order as OrderEntity;
use TechChallenge\Domain\Shared\ValueObjects\Price;

class Order
{
    private ?OrderEntity $order = null;

    public function new(?string $id = null, String|DateTime $created_at = null, String|DateTime $updated_at = null): self
    {
        if (!is_null($created_at))
            $created_at = is_string($created_at) ? new DateTime($created_at) : $created_at;

        if (!is_null($updated_at))
            $updated_at = is_string($updated_at) ? new DateTime($updated_at) : $updated_at;

        $this->order = OrderEntity::create($id, $created_at, $updated_at);

        return $this;
    }

    public function withCustomerId(string $customerId): self
    {
        $this->order->setCustomerId($customerId);

        return $this;
    }

    public function withItems(array $items): self
    {
        //Factory pro item
        //Move pro \Application\UseCase
        //Show productId e quantity
        foreach ($items as $item) {
            $this->order->setItem(Item::create(
                productId: $item['productId'],
                quantity: $item['quantity'],
                price: new Price($item['price']),
            ));
        }

        return $this;
    }

    public function build(): OrderEntity
    {
        return $this->order;
    }
}
