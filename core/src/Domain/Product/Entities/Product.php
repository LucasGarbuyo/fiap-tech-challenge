<?php

namespace TechChallenge\Domain\Product\Entities;

use TechChallenge\Domain\Category\Entities\Category;
use TechChallenge\Domain\Product\Exceptions\ProductException;
use TechChallenge\Domain\SHared\ValueObjects\Price;
use TechChallenge\Domain\Shared\Entities\Standard as StandardEntity;

class Product extends StandardEntity
{
    protected static string $idPrefix = "PROD";

    protected ?Category $category = null;

    protected ?string $categoryId = null;

    protected ?string $name;

    protected ?string $description;

    protected ?string $image = null;

    protected ?Price $price;

    public function setCategoryId(?string $categoryId): self
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    public function setImage(string|null $image): self
    {
        $this->image = $image;

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

    public function setName(string|null $name): self
    {
        if (strlen($name) < 4)
            throw new ProductException("Nome do produto precisa ter 4 ou mais caracteres");

        if (strlen($name) > 255)
            throw new ProductException("Nome do produto não pode ter mais que 255 caracteres");

        $this->name = $name;

        return $this;
    }

    public function getImage(): string|null
    {
        return $this->image;
    }

    public function getName(): string|null
    {
        return $this->name;
    }

    public function setDescription(string|null $description): self
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
}
