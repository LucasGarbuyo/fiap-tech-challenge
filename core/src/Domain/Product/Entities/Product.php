<?php

namespace TechChallenge\Domain\Product\Entities;

use DateTime;
use DomainException;

class Product
{
    private ?string $id = null;
    private ?string $name = null;
    private ?string $description = null;
    private ?float $price = null;
    private ?DateTime $createdAt = null;
    private ?DateTime $updatedAt = null;
    private ?DateTime $deletedAt = null;

    public function __construct(array $data = [])
    {
        $this->setData($data);
    }

    public function setData(array $data): self
    {
        if (isset($data["id"]))
            $this->setId($data["id"]);

        if (isset($data["name"]))
            $this->setName($data["name"]);

        if (isset($data["description"]))
            $this->setDescription($data["description"]);

        if (isset($data["price"]))
            $this->setPrice($data["price"]);

        if (isset($data["createdAt"]))
            $this->setCreatedAt($data["createdAt"]);

        if (isset($data["updatedAt"]))
            $this->setUpdatedAt($data["updatedAt"]);

        return $this;
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
        if (strlen($name) > 255)
            throw new DomainException("Nome do produto não pode ter mais que 255 caracteres");

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

    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCreatedAt(): DateTime|null
    {
        return $this->createdAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUpdatedAt(): DateTime|null
    {
        return $this->updatedAt;
    }

    public function setDeletedAt(DateTime $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function getDeletedAt(): DateTime|null
    {
        return $this->deletedAt;
    }

    public function toArray(): array
    {
        return [
            "id" => $this->getId(),
            "name" => $this->getName(),
            "description" => $this->getDescription(),
            "price" => $this->getPrice(),
            "createdAt" => $this->getCreatedAt() ? $this->getCreatedAt()->format("Y-m-d H:i:s") : null,
            "updatedAt" => $this->getUpdatedAt() ? $this->getUpdatedAt()->format("Y-m-d H:i:s") : null
        ];
    }
}
