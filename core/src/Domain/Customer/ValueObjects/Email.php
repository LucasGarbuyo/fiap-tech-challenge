<?php

namespace TechChallenge\Domain\Customer\ValueObjects;

class Email
{
    private ?string $address = null;

    public function __construct(?string $address)
    {
        $this->setAddress($address);
    }

    public function setAddress(string $address)
    {
        $this->address = $address;
    }

    public function __toString()
    {
        return $this->address;
    }
}
