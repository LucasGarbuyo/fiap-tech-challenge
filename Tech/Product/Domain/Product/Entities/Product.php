<?php

namespace Tech\Product\Domain\Product\Entities;

use DomainException;

class Product
{
    private ?string $id;
    private ?string $name;
    private ?string $description;
    private ?float $price;

    public function __construct()
    {
        $this->id = null;
        $this->name = null;
        $this->description = null;
        $this->price = null;
    }

    public function setId(string $id): self
    {
        if (!empty($this->getId()))
            throw new DomainException("Produto já possui um ID");

        $this->id = $id;

        return $this;
    }

    public function getId(): string|null
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

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription(): string|null
    {
        return $this->description;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPrice(): float|null
    {
        return $this->price;
    }
}
