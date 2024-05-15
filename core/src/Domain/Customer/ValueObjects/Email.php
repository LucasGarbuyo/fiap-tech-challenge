<?php

namespace TechChallenge\Domain\Customer\ValueObjects;

class Email
{
    private readonly string $address;

    public function __construct(string $address)
    {
        $this->setAddress($address);
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function __toString(): String
    {
        return $this->address;
    }
}
