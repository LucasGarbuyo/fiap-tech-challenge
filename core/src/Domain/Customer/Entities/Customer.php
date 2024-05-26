<?php

namespace TechChallenge\Domain\Customer\Entities;

use DateTime;
use TechChallenge\Domain\Customer\ValueObjects\{Cpf, Email};
class Customer
{
    private ?string $name;
    private ?Cpf $cpf;
    private ?Email $email;
    private readonly DateTime $created_at;
    private DateTime $updated_at;
    private ?DateTime $deleted_at;

    public function __construct(
        private readonly string $id,
        DateTime $created_at,
        DateTime $updated_at,
    ) {
        $this
            ->setCreatedAt($created_at)
            ->setUpdatedAt($updated_at);
    }

    public static function create(?string $id = null, ?DateTime $created_at = null, ?DateTime $updated_at = null): self
    {
        return new self(
            id: $id ?? uniqid("CUST_", true),
            created_at: $created_at ?? new DateTime(),
            updated_at: $updated_at ?? new DateTime()
        );
    }

    public function getId(): string
    {
        return $this->id;
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

    public function setCreatedAt(DateTime $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->created_at;
    }

    public function setUpdatedAt(DateTime $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updated_at;
    }

    public function delete(): self
    {
        $this->deleted_at = new DateTime();

        return $this;
    }

    public function getDeletedAt(): DateTime|null
    {
        return $this->deleted_at;
    }

    public function toArray($complete = true): array
    {
        $return = [
            "id" => $this->getId(),
            "name" => $this->getName(),
            "cpf" => (string) $this->getCpf(),
            "email" => (string) $this->getEmail(),
        ];

        if ($complete) {
            $return["created_at"] = $this->getCreatedAt()->format("Y-m-d H:i:s");
            $return["updated_at"] = $this->getUpdatedAt()->format("Y-m-d H:i:s");
        }
        return $return;
    }
}
