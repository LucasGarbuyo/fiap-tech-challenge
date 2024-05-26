<?php

namespace TechChallenge\Domain\Order\Entities;

use DateTime;
use TechChallenge\Domain\Customer\Entities\Customer;
use TechChallenge\Domain\Order\Enum\OrderStatus;
use TechChallenge\Domain\Order\Exceptions\InvalidItemOrder;
use TechChallenge\Domain\Shared\ValueObjects\Price;

class Order
{
    private ?string $customer_id = null;
    private ?Customer $customer = null;
    private Price $price;
    private array $items = [];
    private OrderStatus $status = OrderStatus::RECEIVED;
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

    public function delete(): self
    {
        $this->deleted_at = new DateTime();

        return $this;
    }

    public function setCustomer(Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }
    
    public function setCustomerId(string $customerId): self
    {
        $this->customer_id = $customerId;

        return $this;
    }

    public function getStatus(): OrderStatus
    {
        return $this->status;
    }

    public function setStatus(OrderStatus $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCustomerId(): string|null
    {
        return $this->customer_id;
    }

    public function setItems(array $items): self
    {
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

    public function toArray($complete = true): array
    {
        $return = [
            "id" => $this->getId(),
            "customer" => $this->getCustomer(),
            "items" => $this->getItems(),
        ];

        if ($complete) {
            $return["created_at"] = $this->getCreatedAt()->format("Y-m-d H:i:s");
            $return["updated_at"] = $this->getUpdatedAt()->format("Y-m-d H:i:s");
        }
        return $return;
    }

    public function getPrice(): Price
    {
        $price = 0;
        foreach ($this->items as $item) {
            $price += $item->getPrice()->getValue();
        }
        $this->total = new Price($price);
        return $this->total;
    }
}
