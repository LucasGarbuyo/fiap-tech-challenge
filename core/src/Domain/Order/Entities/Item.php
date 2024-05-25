<?php

namespace TechChallenge\Domain\Order\Entities;

use TechChallenge\Domain\Order\Exceptions\InvalidItemQuantityException;

class Item
{
    private readonly string $id;
    private string $productId;
    private int $quantity;
    public function __construct(
        string $productId,
        int $quantity,
        string $id = null,
    ) {
        $this->id = $id ?? uniqid("ORDE_ITEM", true);
        $this->setProductId($productId);
        $this->setQuantity($quantity);
    }

    public function getId(): string
    {
        return $this->id;
    }
    public function setProductId(string $productId): self
    {
        $this->productId = $productId;

        return $this;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function setQuantity(int $quantity): self
    {
        if ($quantity <= 0) {
            throw new InvalidItemQuantityException();
        }
        $this->quantity = $quantity;

        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
