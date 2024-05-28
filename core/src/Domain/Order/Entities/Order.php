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
    private ?Price $total;
    private array $items = [];
    private OrderStatus $status = OrderStatus::RECEIVED;
    private readonly DateTime $created_at;
    private readonly DateTime $updated_at;
    private ?DateTime $deleted_at = null;

    public function __construct(
        private readonly string $id,
        Price $total,
        DateTime $created_at,
        DateTime $updated_at,
    ) {
        $this
            ->setTotal($total)
            ->setCreatedAt($created_at)
            ->setUpdatedAt($updated_at);
    }

    public static function create(
        ?string $id = null,
        ?Price $total,
        ?DateTime $created_at,
        ?DateTime $updated_at
    ): self {
        return new self(
            id: $id ?? uniqid("ORDE_", true),
            total: $total ?? new Price(0.0),
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

    public function setCustomerId(?string $customerId = null): self
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

    public function getItems(): array
    {
        return $this->items;
    }

    public function setTotal(Price $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getTotal(): Price
    {
        return $this->total;
    }

    public function calcTotal()
    {
        $price = 0;

        foreach ($this->items as $item)
            $price += $item->getTotal()->getValue();

        $this->setTotal(new Price($price));
    }

    public function toArray(): array
    {
        $items = array_map(function ($item) {
            return $item->toArray();
        }, $this->getItems());

        return [
            "id" => $this->getId(),
            "customer_id" => $this->getCustomerId(),
            "customer" => $this->getCustomer() ? $this->getCustomer()->toArray() : null,
            "total" => $this->getTotal()->getValue(),
            "status" => $this->getStatus(),
            "items" => $items,
            "created_at" => $this->getCreatedAt()->format("Y-m-d H:i:s"),
            "updated_at" => $this->getUpdatedAt()->format("Y-m-d H:i:s")
        ];
    }
}
