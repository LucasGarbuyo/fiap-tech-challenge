<?php

namespace TechChallenge\Domain\Order\Entities;

use DateTime;
use TechChallenge\Domain\Order\Exceptions\InvalidItemQuantityException;
use TechChallenge\Domain\Shared\ValueObjects\Price;

class Item
{
    private string $productId;
    private int $quantity;
    private Price $productPrice;
    private readonly DateTime $created_at;
    private readonly DateTime $updated_at;

    public function __construct(
        private readonly string $id,
        string $productId,
        int $quantity,
        Price $productPrice,
        ?DateTime $created_at = null,
        ?DateTime $updated_at = null
    ) {
        $this->setProductId($productId)
            ->setQuantity($quantity)
            ->setProductPrice($productPrice);
    }

    public static function create(
        string $productId,
        int $quantity,
        Price $productPrice,
        ?string $id = null,
        ?DateTime $created_at = null,
        ?DateTime $updated_at = null
    ): self {
        return new self(
            id: $id ?? uniqid("ORDE_ITEM", true),
            productId: $productId,
            quantity: $quantity,
            productPrice: $productPrice,
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

    public function setProductPrice(Price $price): self
    {
        $this->productPrice = $price;

        return $this;
    }

    public function getProductPrice(): Price
    {
        return $this->productPrice;
    }

    public function getPrice(): Price
    {
        $total = $this->productPrice->getValue() * $this->quantity;
        return new Price($total);
    }

    public function toArray(): array
    {
        $return = [
            "id" => $this->getId(),
            "product_id" => $this->getProductId(),
            "quantity" => $this->getQuantity(),
            "price" => $this->getPrice()->getValue(),
        ];

        return $return;
    }
}
