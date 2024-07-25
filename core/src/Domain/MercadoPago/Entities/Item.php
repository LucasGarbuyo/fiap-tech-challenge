<?php

namespace TechChallenge\Domain\Order\Entities;

use TechChallenge\Domain\Shared\Entities\Standard as StandardEntity;
use TechChallenge\Domain\Order\Exceptions\InvalidItemQuantityException;
use TechChallenge\Domain\Shared\ValueObjects\Price;

class Item extends StandardEntity
{
    protected static string $idPrefix = "ITEM";

    protected readonly string $productId;

    protected readonly string $orderId;

    protected ?int $quantity = null;

    protected ?Price $price = null;

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function setProductId(string $productId): self
    {
        $this->productId = $productId;

        return $this;
    }

    public function getOrderId(): string
    {
        return $this->orderId;
    }

    public function setOrderId(string $orderId): self
    {
        $this->orderId = $orderId;

        return $this;
    }

    public function setQuantity(?int $quantity): self
    {
        if (is_null($quantity) || $quantity <= 0)
            throw new InvalidItemQuantityException();

        $this->quantity = $quantity;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setPrice(?Price $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPrice(): ?Price
    {
        return $this->price;
    }

    public function getTotal(): Price
    {
        $total = $this->getPrice()->getValue() * $this->getQuantity();

        return new Price($total);
    }
}
