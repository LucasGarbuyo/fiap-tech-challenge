<?php

namespace TechChallenge\Domain\Order\Factories;

use DateTime;
use TechChallenge\Domain\Customer\Entities\Customer;
use TechChallenge\Domain\Order\Enum\OrderStatus;
use TechChallenge\Domain\Order\Entities\Order as OrderEntity;
use TechChallenge\Domain\Shared\ValueObjects\Price;

class Order
{
    private ?OrderEntity $order = null;

    public function new(?string $id = null, float $total = 0, String|DateTime $created_at = null, String|DateTime $updated_at = null): self
    {
        if (!is_null($created_at))
            $created_at = is_string($created_at) ? new DateTime($created_at) : $created_at;

        if (!is_null($updated_at))
            $updated_at = is_string($updated_at) ? new DateTime($updated_at) : $updated_at;

        $this->order = OrderEntity::create($id, new Price($total), $created_at, $updated_at);

        return $this;
    }

    public function withCustomerId(?string $customerId): self
    {
        $this->order->setCustomerId($customerId);

        return $this;
    }

    public function withCustomer(Customer $customer): self
    {
        $this->order->setCustomer($customer);

        return $this;
    }

    public function withCustomerIdCustomer(string $customer_id, Customer $customer): self
    {
        $this->order->setCustomerId($customer_id)
            ->setCustomer($customer);

        return $this;
    }

    public function withItems(array $items): self
    {
        $this->order->setItems($items);

        return $this;
    }

    public function withStatusHistories(array $statusHistories): self
    {
        $this->order->setStatusHistories($statusHistories);

        return $this;
    }

    public function withStatus(string|OrderStatus $status): self
    {
        if (is_string($status))
            $status = OrderStatus::from($status);

        $this->order->setStatus($status);

        return $this;
    }

    public function build(): OrderEntity
    {
        return $this->order;
    }
}
