<?php

namespace TechChallenge\Domain\Customer\ValueObjects;

use TechChallenge\Domain\Customer\Exceptions\CustomerException;

class Cpf
{
    private readonly string $document;

    public function __construct(string|null $document)
    {
        $this->setDocument($document);
    }

    public function setDocument(string|null $document): self
    {
        $document = preg_replace('/[^\d]+/', '', $document);

        if (strlen($document) != 11)
            throw new CustomerException("Cpf inválido");

        $this->document = $document;

        return $this;
    }

    public function __toString(): String
    {
        return $this->document;
    }
}
