<?php

namespace TechChallenge\Domain\Shared\Entities;

use DateTime;
use TechChallenge\Domain\Shared\Facade\Uuid;

abstract class Standard
{
    protected static string $idPrefix;

    protected ?DateTime $updatedAt = null;

    protected ?DateTime $deletedAt = null;

    public function __construct(
        protected readonly string $id,
        protected readonly DateTime $createdAt,
        DateTime $updatedAt
    ) {
        $this->setUpdatedAt($updatedAt);
    }

    public static function create(
        ?string $id = null,
        ?DateTime $createdAt = null,
        ?DateTime $updatedAt = null
    ): static {
        return new static(
            id: $id ? $id : Uuid::generate(static::$idPrefix),
            createdAt: $createdAt ?? new DateTime(),
            updatedAt: $updatedAt ?? new DateTime()
        );
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function delete(): self
    {
        $this->deletedAt = new DateTime();

        return $this;
    }

    public function getDeletedAt(): ?DateTime
    {
        return $this->deletedAt;
    }

    public function isDeleted(): bool
    {
        return $this->getDeletedAt() !== null;
    }
}
