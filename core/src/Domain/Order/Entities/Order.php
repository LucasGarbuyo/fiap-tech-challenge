<?php

namespace TechChallenge\Domain\Order\Entities;

use DateTime;
use TechChallenge\Domain\Order\Exceptions\{
    InvalidItemOrder,
    InvalidOrderItemQuantityException
};
use TechChallenge\Domain\Shared\ValueObjects\Price;

class Order
{
    private ?string $customerId = null;
    private Price $total;
    private array $items = [];
    private string $status;
    private readonly DateTime $created_at;
    private readonly DateTime $updated_at;
    private ?DateTime $deleted_at = null;

    public function __construct(
        private readonly string $id,
        DateTime $created_at,
        DateTime $updated_at,
    ) {
        $this
            ->setCreatedAt($created_at)
            ->setUpdatedAt($updated_at);
    }

    public static function create(
        ?string $id = null,
        ?DateTime $created_at = null,
        ?DateTime $updated_at = null
    ): self {
        return new self(
            id: $id ?? uniqid("ORDE_", true),
            created_at: $created_at ?? new DateTime(),
            updated_at: $updated_at ?? new DateTime(),
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

    public function getCustomerId(): string|null
    {
        return $this->customerId;
    }

    public function setItems(array $items): self
    {
        dd($items);
        if (empty($items))
            throw new InvalidOrderItemQuantityException();

        foreach ($items as $item) {
            if (!$item instanceof Item)
                throw new InvalidItemOrder();

            $this->items[] = $item;
        }

        return $this;
    }

    public function setItem(Item $item): self
    {
        $this->items[] = $item;

        return $this;
    }

    /** @return Item[] */
    public function getItems(): array
    {
        return $this->items;
    }
}
