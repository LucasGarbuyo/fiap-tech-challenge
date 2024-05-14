<?php

namespace TechChallenge\Domain\Product\Entities;

use DateTime;
use TechChallenge\Domain\Product\Exceptions\ProductException;

class Product
{
    private ?string $id = null;
    private ?string $name = null;
    private ?string $description = null;
    private ?float $price = null;
    private ?DateTime $created_at = null;
    private ?DateTime $updated_at = null;
    private ?DateTime $deleted_at = null;

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

        if (isset($data["created_at"]))
            $this->setCreatedAt($data["created_at"]);

        if (isset($data["updated_at"]))
            $this->setUpdatedAt($data["updated_at"]);

        return $this;
    }

    public function setId(string $id): self
    {
        if (!empty($this->getId()))
            throw new ProductException("Produto já possui um ID");

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
            throw new ProductException("Nome do produto não pode ter mais que 255 caracteres");

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

    public function setCreatedAt(String|DateTime $createdAt): self
    {
        $this->created_at = is_string($createdAt) ? new DateTime($createdAt) : $createdAt;

        return $this;
    }

    public function getCreatedAt(): DateTime|null
    {
        return $this->created_at;
    }

    public function setUpdatedAt(String|DateTime $updatedAt): self
    {
        $this->updated_at = is_string($updatedAt) ? new DateTime($updatedAt) : $updatedAt;

        return $this;
    }

    public function getUpdatedAt(): DateTime|null
    {
        return $this->updated_at;
    }

    public function setDeletedAt(DateTime $deletedAt): self
    {
        $this->deleted_at = is_string($deletedAt) ? new DateTime($deletedAt) : $deletedAt;

        return $this;
    }

    public function getDeletedAt(): DateTime|null
    {
        return $this->deleted_at;
    }

    public function toArray(): array
    {
        return [
            "id" => $this->getId(),
            "name" => $this->getName(),
            "description" => $this->getDescription(),
            "price" => $this->getPrice(),
            "created_at" => $this->getCreatedAt() ? $this->getCreatedAt()->format("Y-m-d H:i:s") : null,
            "updated_at" => $this->getUpdatedAt() ? $this->getUpdatedAt()->format("Y-m-d H:i:s") : null
        ];
    }
}
