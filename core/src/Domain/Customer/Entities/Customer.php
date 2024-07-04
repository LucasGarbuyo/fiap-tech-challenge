<?php

namespace TechChallenge\Domain\Customer\Entities;

use TechChallenge\Domain\Shared\Entities\Standard as StandardEntity;
use DateTime;
use TechChallenge\Domain\Customer\Exceptions\CustomerException;
use TechChallenge\Domain\Customer\ValueObjects\Cpf;
use TechChallenge\Domain\Customer\ValueObjects\Email;
use TechChallenge\Domain\Shared\Facade\Uuid;

class Customer extends StandardEntity
{
    private ?string $name = null;
    private ?Cpf $cpf = null;
    private ?Email $email = null;
    private readonly DateTime $createdAt;
    private DateTime $updatedAt;
    private ?DateTime $deletedAt = null;

    public function __construct(
        private readonly string $id,
        DateTime $createdAt,
        DateTime $updatedAt,
    ) {
        $this
            ->setCreatedAt($createdAt)
            ->setUpdatedAt($updatedAt);
    }

    public static function create(
        ?string $id = null,
        ?DateTime $createdAt = null,
        ?DateTime $updatedAt = null
    ): self {
        return new self(
            id: $id ? $id : Uuid::generate("CUST"),
            createdAt: $createdAt ?? new DateTime(),
            updatedAt: $updatedAt ?? new DateTime()
        );
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setName(string|null $name): self
    {
        if (strlen($name) < 3)
            throw new CustomerException("Nome do cliente deve ter 3 ou mais caracteres");

        if (strlen($name) > 255)
            throw new CustomerException("Nome do cliente deve ter no máximo 255 caracteres");

        $this->name = $name;

        return $this;
    }

    public function getName(): string|null
    {
        return $this->name;
    }

    public function setCpf(Cpf $cpf): self
    {
        $this->cpf = $cpf;

        return $this;
    }

    public function getCpf(): Cpf
    {
        return $this->cpf;
    }

    public function setEmail(Email $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
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

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function delete(): self
    {
        $this->deletedAt = new DateTime();

        return $this;
    }

    public function getDeletedAt(): DateTime|null
    {
        return $this->deletedAt;
    }
}
