<?php

namespace TechChallenge\Domain\Order\Entities;

use DateTime;
use TechChallenge\Domain\Order\Exceptions\InvalidOrderItemQuantityException;

class Order
{
    private string $customerId;
    private array $items;
    private readonly DateTime $created_at;
    private readonly DateTime $updated_at;
    private ?DateTime $deleted_at = null;

    public function __construct(
        private readonly string $id,
        DateTime $created_at,
        DateTime $updated_at,
        string $customerId,
        array $items
    ) {
        $this
            ->setCreatedAt($created_at)
            ->setUpdatedAt($updated_at)
            ->setCustomerId($customerId)
            ->setItems($items);
        $this->items = [];
    }

    public static function create(
        string $customerId,
        array $items,
        ?string $id = null,
        ?DateTime $created_at = null,
        ?DateTime $updated_at = null
    ): self {
        return new self(
            id: $id ?? uniqid("ORDE_", true),
            created_at: $created_at ?? new DateTime(),
            updated_at: $updated_at ?? new DateTime(),
            customerId: $customerId,
            items: $items
        );
    }

    public function getId(): string
    {
        return $this->id;
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

    public function setDeleteAt(): self
    {
        $this->deleted_at = new DateTime();

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

    public function getDeletedAt(): DateTime|null
    {
        return $this->deleted_at;
    }

    public function setCustomerId(string $customerId): self
    {
        $this->customerId = $customerId;

        return $this;
    }

    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    public function setItems(array $items): self
    {
        if (empty($items)) {
            throw new InvalidOrderItemQuantityException();
        }
        foreach ($items as $item) {
            $this->items[] = new Item($item['productId'], $item['quantity']);
        }
        return $this;
    }

    public function setItem(string $productId, int $quantity): self
    {
        $this->items[] = new Item($productId, $quantity);
        return $this;
    }

    /** @return Item[] */
    public function getItems(): array
    {
        return $this->items;
    }
}
