<?php

namespace TechChallenge\Domain\Order\Entities;

use TechChallenge\Domain\Shared\Entities\Standard as StandardEntity;
use DateTime;
use TechChallenge\Domain\Customer\Entities\Customer;
use TechChallenge\Domain\Order\Enum\OrderStatus;
use TechChallenge\Domain\Order\Exceptions\InvalidItemOrder;
use TechChallenge\Domain\Order\Exceptions\InvalidStatusOrder;
use TechChallenge\Domain\Shared\ValueObjects\Price;

class Order extends StandardEntity
{
    protected static string $idPrefix = "ORDE";

    protected ?string $customerId = null;

    protected ?Customer $customer = null;

    protected ?Price $total;

    protected array $items = [];

    protected array $statusHistory = [];

    protected ?OrderStatus $status = null;

    public function delete(): self
    {
        $this->deletedAt = new DateTime();

        foreach ($this->getItems() as $item)
            $item->delete();

        foreach ($this->getStatusHistories() as $status)
            $status->delete();

        return $this;
    }

    public function setCustomer(?Customer $customer): self
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
        $this->customerId = $customerId;

        return $this;
    }

    public function getStatus(): ?OrderStatus
    {
        return $this->status;
    }

    public function getStatusHistories(): array
    {
        return $this->statusHistory;
    }

    public function setStatusHistories(array $statusHistories): self
    {
        foreach ($statusHistories as $statusHistory) {
            if (!$statusHistory instanceof Status)
                throw new InvalidStatusOrder();

            $this->addStatusHistory($statusHistory);
        }

        return $this;
    }

    protected function addStatusHistory(Status $statusHistory): self
    {
        $this->statusHistory[] = $statusHistory;

        return $this;
    }

    public function setAsNew(): self
    {
        $this->addStatus(OrderStatus::NEW);

        return $this;
    }

    public function setAsReceived(): self
    {
        $this->addStatus(OrderStatus::RECEIVED);

        return $this;
    }

    public function setAsPaid(): self
    {
        $this->addStatus(OrderStatus::PAID);

        return $this;
    }

    public function setAsInPreparation(): self
    {
        $this->addStatus(OrderStatus::IN_PREPARATION);

        return $this;
    }

    public function setAsReady(): self
    {
        $this->addStatus(OrderStatus::READY);

        return $this;
    }

    public function setAsFinished(): self
    {
        $this->addStatus(OrderStatus::FINISHED);

        return $this;
    }

    public function setAsCanceled(): self
    {
        $this->addStatus(OrderStatus::CANCELED);

        return $this;
    }

    protected function addStatus(OrderStatus $OrderStatus): self
    {
        $status = Status::create();

        $status
            ->setOrderId($this->getId())
            ->setStatus($OrderStatus);

        $this->addStatusHistory($status);

        $this->setStatus($status->getStatus());

        return $this;
    }

    public function isNew(): bool
    {
        return $this->getStatus() === OrderStatus::NEW;
    }

    public function isReceived(): bool
    {
        return $this->getStatus() === OrderStatus::RECEIVED;
    }

    public function isPaid(): bool
    {
        return $this->getStatus() === OrderStatus::PAID;
    }

    public function isCanceled(): bool
    {
        return $this->getStatus() === OrderStatus::CANCELED;
    }

    public function setStatus(OrderStatus $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCustomerId(): ?string
    {
        return $this->customerId;
    }

    public function setItems(array $items): self
    {
        foreach ($items as $item) {
            if (!$item instanceof Item)
                throw new InvalidItemOrder();

            $this->setItem($item);
        }

        return $this;
    }

    public function setItem(Item $item): self
    {
        $exist = false;

        foreach ($this->getItems() as $orderItem) {
            if ($orderItem->getProductId() === $item->getProductId()) {
                $orderItem->setQuantity($item->getQuantity());
                $orderItem->setPrice($item->getPrice());
                $exist = true;
                break;
            }
        }

        if (!$exist)
            $this->items[] = $item;

        return $this;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function setTotal(?Price $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getTotal(): ?Price
    {
        return $this->total;
    }

    public function calcTotal(): self
    {
        $price = 0;

        foreach ($this->items as $item) {
            if ($item->isDeleted())
                continue;

            $price += $item->getTotal()->getValue();
        }

        $this->setTotal(new Price($price));

        return $this;
    }

    public function removeItemsByProductIdsNotIn(array $idsProducts): self
    {
        foreach ($this->getItems() as $item)
            if (!in_array($item->getProductId(), $idsProducts))
                $item->delete();

        return $this;
    }
}
