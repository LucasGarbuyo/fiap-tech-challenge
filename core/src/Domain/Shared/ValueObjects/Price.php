<?php

namespace TechChallenge\Domain\Shared\ValueObjects;

class Price
{
    private float $value;

    public function __construct($value)
    {
        $this->setValue($value);
    }

    public function setValue($value): self
    {
        $value = trim($value);

        if (preg_match('/^\d{1,3}(\.\d{3})*,\d{2}$/', $value)) {
            $value = str_replace('.', '', $value);
            $value = str_replace(',', '.', $value);
        } elseif (preg_match('/^\d{1,3}(,\d{3})*\.\d{2}$/', $value)) {
            $value = str_replace(',', '', $value);
        } elseif (!is_numeric($value)) {
            throw new \InvalidArgumentException("Invalid price value");
        }

        $this->value = (float) $value;
      
        return $this;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
