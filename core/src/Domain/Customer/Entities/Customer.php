<?php

namespace TechChallenge\Domain\Customer\Entities;

use TechChallenge\Domain\Shared\Entities\Standard as StandardEntity;
use TechChallenge\Domain\Customer\Exceptions\CustomerException;
use TechChallenge\Domain\Customer\ValueObjects\Cpf;
use TechChallenge\Domain\Customer\ValueObjects\Email;

class Customer extends StandardEntity
{
    protected static string $idPrefix = "CUST";

    protected ?string $name = null;

    protected ?Cpf $cpf = null;

    protected ?Email $email = null;

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
}
