<?php

namespace TechChallenge\Domain\Order\Entities;

use DateTime;

class Order
{
    private string $customerId;
    private array $items;
    private readonly DateTime $created_at;
    private readonly DateTime $updated_at;
    private readonly DateTime $deleted_at;

    public function __construct(
        private readonly string $id,
        DateTime $created_at,
        DateTime $updated_at,
    ) {
        $this
            ->setCreatedAt($created_at)
            ->setUpdatedAt($updated_at);
        $this->items = [];
    }

    public static function create(
        ?string $id = null,
        ?DateTime $created_at = null,
        ?DateTime $updated_at = null
    ): self {
        return new self(
            id: $id ?? uniqid("ORDE_", true),
            created_at: $created_at ?? new DateTime(),
            updated_at: $updated_at ?? new DateTime()
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
