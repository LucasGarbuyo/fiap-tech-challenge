<?php

namespace TechChallenge\Domain\Order\Factories;

use DateTime;
use TechChallenge\Domain\Order\Entities\Order as OrderEntity;

class Order
{
    private ?string $id;
    private ?DateTime $created_at;
    private ?DateTime $updated_at;
    private string $customerId;
    private array $items;

    public function __construct()
    {
        $this->id = null;
        $this->created_at = null;
        $this->updated_at = null;
        $this->items = [];
    }

    public function withId(?string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function withTimestamps(?DateTime $created_at, ?DateTime $updated_at): self
    {
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        return $this;
    }

    public function withCustomerId(string $customerId): self
    {
        $this->customerId = $customerId;
        return $this;
    }

    public function withItems(array $items): self
    {
        $this->items = $items;
        return $this;
    }

    public function build(): OrderEntity
    {
        return OrderEntity::create(
            $this->customerId,
            $this->items,
            $this->id,
            $this->created_at,
            $this->updated_at
        );
    }
}
