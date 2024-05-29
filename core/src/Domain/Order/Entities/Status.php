<?php

namespace TechChallenge\Domain\Order\Entities;

use DateTime;
use TechChallenge\Domain\Order\Enum\OrderStatus;

class Status
{
    private readonly DateTime $created_at;
    private readonly DateTime $updated_at;
    private ?DateTime $deleted_at;

    public function __construct(
        private readonly string $id,
        private readonly string $order_id,
        private readonly OrderStatus $status,
        DateTime $created_at,
        DateTime $updated_at
    ) {
        $this->setCreatedAt($created_at)
            ->setUpdatedAt($updated_at);
    }

    public static function create(
        ?string $id = null,
        string $order_id,
        OrderStatus $status,
        ?DateTime $created_at = null,
        ?DateTime $updated_at = null
    ): self {
        return new self(
            id: $id ?? uniqid("STAT_", true),
            order_id: $order_id,
            status: $status,
            created_at: $created_at ?? new DateTime(),
            updated_at: $updated_at ?? new DateTime(),
        );
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getOrderId(): string
    {
        return $this->order_id;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTime $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(DateTime $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getStatus(): OrderStatus
    {
        return $this->status;
    }

    public function getDeletedAt(): DateTime|null
    {
        if (isset($this->deleted_at))
            return $this->deleted_at;

        return null;
    }

    public function toArray(): array
    {
        return [
            "id" => $this->getId(),
            "id_order" => $this->getOrderId(),
            "status" => $this->getStatus(),
            "created_at" => $this->getCreatedAt()->format("Y-m-d H:i:s"),
            "updated_at" => $this->getUpdatedAt()->format("Y-m-d H:i:s")
        ];
    }
}
