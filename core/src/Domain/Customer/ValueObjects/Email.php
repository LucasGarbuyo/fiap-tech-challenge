<?php

namespace TechChallenge\Domain\Customer\ValueObjects;

use TechChallenge\Domain\Customer\Exceptions\CustomerException;

class Email
{
    private readonly string $address;

    public function __construct(string|null $address)
    {
        $this->setAddress($address);
    }

    public function setAddress(string|null $address): self
    {
        if (filter_var($address, FILTER_VALIDATE_EMAIL) === false)
            throw new CustomerException("E-mail inválido");

        $this->address = $address;

        return $this;
    }

    public function __toString(): String
    {
        return $this->address;
    }
}
