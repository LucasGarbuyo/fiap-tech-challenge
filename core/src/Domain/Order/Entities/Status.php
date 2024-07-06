<?php

namespace TechChallenge\Domain\Order\Entities;

use TechChallenge\Domain\Shared\Entities\Standard as StandardEntity;
use TechChallenge\Domain\Order\Enum\OrderStatus;

class Status extends StandardEntity
{
    protected static string $idPrefix = "STAT";

    protected readonly string $orderId;

    protected readonly OrderStatus $status;

    public function getOrderId(): string
    {
        return $this->orderId;
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

    public function setOrderId(string $orderId): self
    {
        $this->orderId = $orderId;

        return $this;
    }
}
