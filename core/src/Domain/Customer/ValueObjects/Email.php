<?php

namespace TechChallenge\Domain\Customer\ValueObjects;

class Email
{
    private ?string $address = null;

    public function __construct(?string $address)
    {
        $this->setAddress($address);
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function __toString(): String
    {
        return $this->address;
    }
}
