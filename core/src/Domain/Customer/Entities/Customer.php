<?php

namespace TechChallenge\Domain\Customer\Entities;

use TechChallenge\Domain\Customer\Exceptions\CustomerException;
use TechChallenge\Domain\Customer\ValueObjects\Cpf;
use TechChallenge\Domain\Customer\ValueObjects\Email;

class Customer
{
    private ?string $id = null;
    private ?string $name = null;
    private ?Cpf $cpf = null;
    private ?Email $email = null;

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

    public function toArray(): array
    {
        return [
            "id" => $this->getId(),
            "name" => $this->getName(),
            "cpf" => (string) $this->getCpf(),
            "email" => (string) $this->getEmail()
        ];
    }
}
