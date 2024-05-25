<?php

namespace TechChallenge\Domain\Order\Entities;

use DateTime;
use TechChallenge\Domain\Order\Exceptions\InvalidItemQuantityException;
use TechChallenge\Domain\Shared\ValueObjects\Price;

class Item
{
    private string $productId;
    private int $quantity;
    private Price $price;
    private readonly DateTime $created_at;
    private readonly DateTime $updated_at;

    public function __construct(
        private readonly string $id,
        string $productId,
        int $quantity,
        Price $price,
        DateTime $created_at,
        DateTime $updated_at,
    ) {
        $this->setProductId($productId)
            ->setQuantity($quantity)
            ->setPrice($price)
            ->setCreatedAt($created_at)
            ->setUpdatedAt($updated_at);
    }

    public static function create(
        ?string $id = null,
        string $productId,
        int $quantity,
        Price $price,
        ?DateTime $created_at = null,
        ?DateTime $updated_at = null
    ): self {
        return new self(
            id: $id ?? uniqid("ORDE_ITEM", true),
            productId: $productId,
            quantity: $quantity,
            price: $price,
            created_at: $created_at ?? new DateTime(),
            updated_at: $updated_at ?? new DateTime(),
        );
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
        if ($quantity <= 0)
            throw new InvalidItemQuantityException();

        $this->quantity = $quantity;

        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setCreatedAt(DateTime $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function setUpdatedAt(DateTime $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function setPrice(Price $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }
}
