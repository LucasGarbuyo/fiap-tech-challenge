<?php

namespace TechChallenge\Domain\Customer\Entities;

use DateTime;
use TechChallenge\Domain\Customer\Exceptions\CustomerException;
use TechChallenge\Domain\Customer\ValueObjects\Cpf;
use TechChallenge\Domain\Customer\ValueObjects\Email;

class Customer
{
    private ?string $id = null;
    private ?string $name = null;
    private ?Cpf $cpf = null;
    private ?Email $email = null;
    private ?DateTime $created_at = null;
    private ?DateTime $updated_at = null;
    private ?DateTime $deleted_at = null;

    public function __construct(?string $id = null, ?string $name = null, ?Cpf $cpf = null, ?Email $email = null)
    {
        $this->setId($id)
            ->setName($name)
            ->setCpf($cpf)
            ->setEmail($email);
    }

    public function getId(): string|null
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        if (!empty($this->getId()))
            throw new CustomerException("Cliente já possui um ID");

        $this->id = $id;

        return $this;
    }

    public function setName(string $name): self
    {
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

    public function setCreatedAt(String|DateTime $createdAt): self
    {
        $this->created_at = is_string($createdAt) ? new DateTime($createdAt) : $createdAt;

        return $this;
    }

    public function getCreatedAt(): DateTime|null
    {
        return $this->created_at;
    }

    public function setUpdatedAt(String|DateTime $updatedAt): self
    {
        $this->updated_at = is_string($updatedAt) ? new DateTime($updatedAt) : $updatedAt;

        return $this;
    }

    public function getUpdatedAt(): DateTime|null
    {
        return $this->updated_at;
    }

    public function setDeletedAt(DateTime $deletedAt): self
    {
        $this->deleted_at = is_string($deletedAt) ? new DateTime($deletedAt) : $deletedAt;

        return $this;
    }

    public function getDeletedAt(): DateTime|null
    {
        return $this->deleted_at;
    }

    public function toArray(): array
    {
        return [
            "id" => $this->getId(),
            "name" => $this->getName(),
            "cpf" => (string) $this->getCpf(),
            "email" => (string) $this->getEmail(),
            "created_at" => $this->getCreatedAt()->format("Y-m-d H:i:s"),
            "updated_at" => $this->getUpdatedAt()->format("Y-m-d H:i:s"),
        ];
    }
}
