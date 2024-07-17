<?php

namespace TechChallenge\Domain\Order\SimpleFactory;

use DateTime;
use TechChallenge\Domain\Order\Entities\Item as ItemEntity;
use TechChallenge\Domain\Shared\ValueObjects\Price;

class Item
{
    private ?ItemEntity $item = null;

    public function new(
        ?string $id = null,
        ?string $productId = NULL,
        ?string $orderId = NULL,
        null|string|DateTime $createdAt = null,
        null|string|DateTime $updatedAt = null
    ): self {
        if (!is_null($createdAt))
            $createdAt = is_string($createdAt) ? new DateTime($createdAt) : $createdAt;

        if (!is_null($updatedAt))
            $updatedAt = is_string($updatedAt) ? new DateTime($updatedAt) : $updatedAt;

        $this->item = ItemEntity::create($id, $createdAt, $updatedAt);
        $this->item
            ->setOrderId($orderId)
            ->setProductId($productId);

        return $this;
    }

    public function restore(
        ?string $id = null,
        ?string $productId = NULL,
        ?string $orderId = NULL,
        null|string|DateTime $createdAt = null,
        null|string|DateTime $updatedAt = null
    ): self {
        if (!is_null($createdAt))
            $createdAt = is_string($createdAt) ? new DateTime($createdAt) : $createdAt;

        if (!is_null($updatedAt))
            $updatedAt = is_string($updatedAt) ? new DateTime($updatedAt) : $updatedAt;

        $this->item = new ItemEntity($id, $createdAt, $updatedAt);

        $this->item
            ->setOrderId($orderId)
            ->setProductId($productId);

        return $this;
    }

    public function withQuantityPrice(?int $quantity, ?float $price): self
    {
        $this->item
            ->setQuantity($quantity)
            ->setPrice(new Price($price));

        return $this;
    }

    public function build(): ItemEntity
    {
        return $this->item;
    }
}
