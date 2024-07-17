<?php

namespace TechChallenge\Domain\Order\SimpleFactory;

use DateTime;
use TechChallenge\Domain\Order\Entities\Status as StatusEntity;
use TechChallenge\Domain\Order\Enum\OrderStatus;

class Status
{
    private ?StatusEntity $status = null;

    public function restore(
        ?string $id = null,
        ?string $orderId = NULL,
        ?string $status = NULL,
        null|string|DateTime $createdAt = null,
        null|string|DateTime $updatedAt = null
    ): self {
        if (!is_null($createdAt))
            $createdAt = is_string($createdAt) ? new DateTime($createdAt) : $createdAt;

        if (!is_null($updatedAt))
            $updatedAt = is_string($updatedAt) ? new DateTime($updatedAt) : $updatedAt;

        $this->status = new StatusEntity($id, $createdAt, $updatedAt);

        $this->status
            ->setOrderId($orderId)
            ->setStatus(OrderStatus::from($status));

        return $this;
    }

    public function build(): StatusEntity
    {
        return $this->status;
    }
}
