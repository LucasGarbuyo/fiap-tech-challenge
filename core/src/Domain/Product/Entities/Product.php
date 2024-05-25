<?php

namespace TechChallenge\Domain\Product\Entities;

use DateTime;
use TechChallenge\Domain\Category\Entities\Category;
use TechChallenge\Domain\Product\Exceptions\ProductException;
use TechChallenge\Domain\SHared\ValueObjects\Price;

class Product
{
    private ?Category $category;
    private ?string $categoryId = null;
    private ?string $name;
    private ?string $description;
    private ?Price $price;
    private readonly DateTime $created_at;
    private DateTime $updated_at;
    private ?DateTime $deleted_at;

    public function __construct(
        private readonly string $id,
        DateTime $created_at,
        DateTime $updated_at,
    ) {
        $this
            ->setCreatedAt($created_at)
            ->setUpdatedAt($updated_at);
    }

    public static function create(?string $id = null, ?DateTime $created_at = null, ?DateTime $updated_at = null)
    {
        return new self(
            id: $id ?? uniqid("PROD_", true),
            created_at: $created_at ?? new DateTime(),
            updated_at: $updated_at ?? new DateTime()
        );
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setCategoryId(string $categoryId): self
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    public function getCategoryId(): string|null
    {
        return $this->categoryId;
    }

    public function setCategory(Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getCategory(): Category|null
    {
        return $this->category;
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

    public function setPrice(Price $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }

    public function setCreatedAt(DateTime $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getCreatedAt(): DateTime|null
    {
        return $this->created_at;
    }

    public function setUpdatedAt(DateTime $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getUpdatedAt(): DateTime|null
    {
        return $this->updated_at;
    }

    public function delete(): self
    {
        $this->deleted_at = new DateTime();

        return $this;
    }

    public function getDeletedAt(): DateTime|null
    {
        return $this->deleted_at;
    }

    public function toArray($complete = true): array
    {
        $return = [
            "id" => $this->getId(),
            "name" => $this->getName(),
            "description" => $this->getDescription(),
            "price" => $this->getPrice()->getValue(),
        ];

        if ($complete) {
            $reutnr["category"] = $this->getCategory()->toArray();
            $reutnr["created_at"] = $this->getCreatedAt() ? $this->getCreatedAt()->format("Y-m-d H:i:s") : null;
            $reutnr["updated_at"] = $this->getUpdatedAt() ? $this->getUpdatedAt()->format("Y-m-d H:i:s") : null;
        }

        return $return;
    }
}
