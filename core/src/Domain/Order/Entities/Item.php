<?php

namespace TechChallenge\Domain\Order\Entities;

use DateTime;
use TechChallenge\Domain\Order\Exceptions\InvalidItemQuantityException;
use TechChallenge\Domain\Shared\ValueObjects\Price;

class Item
{
    private int $quantity;
    private Price $price;
    private readonly DateTime $created_at;
    private readonly DateTime $updated_at;
    private ?DateTime $deleted_at;

    public function __construct(
        private readonly string $id,
        private readonly string $product_id,
        private readonly string $order_id,
        DateTime $created_at,
        DateTime $updated_at
    ) {
        $this->setCreatedAt($created_at)
            ->setUpdatedAt($updated_at);
    }

    public static function create(
        ?string $id = null,
        string $product_id,
        string $order_id,
        ?DateTime $created_at = null,
        ?DateTime $updated_at = null
    ): self {
        return new self(
            id: $id ?? uniqid("ITEM_", true),
            product_id: $product_id,
            order_id: $order_id,
            created_at: $created_at ?? new DateTime(),
            updated_at: $updated_at ?? new DateTime(),
        );
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getProductId(): string
    {
        return $this->product_id;
    }

    public function getOrderId(): string
    {
        return $this->order_id;
    }

    public function setQuantity(?int $quantity): self
    {
        if (is_null($quantity) || $quantity <= 0)
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

    public function getCreatedAt(): DateTime
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(DateTime $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function delete(): self
    {
        $this->deleted_at = new DateTime();

        return $this;
    }

    public function getDeletedAt(): DateTime|null
    {
        return $this->deleted_at;
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

    public function getTotal(): Price
    {
        $total = $this->getPrice()->getValue() * $this->getQuantity();

        return new Price($total);
    }

    public function toArray(): array
    {
        return [
            "id" => $this->getId(),
            "product_id" => $this->getProductId(),
            "order_id" => $this->getOrderId(),
            "quantity" => $this->getQuantity(),
            "price" => $this->getPrice()->getValue(),
        ];
    }
}
