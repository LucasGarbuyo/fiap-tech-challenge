<?php

namespace TechChallenge\Domain\Customer\ValueObjects;

use DomainException;

class Cpf
{
    private string $document = null;

    public function __construct(string $document)
    {
        $this->setDocument($document);
    }

    public function setDocument(string $document)
    {
        $document = preg_replace('/\d+/', '', $document);

        if (strlen($document) != 11)
            throw new DomainException("Documento inválido");

        $this->document = $document;
    }

    public function __toString()
    {
        return $this->document;
    }
}
