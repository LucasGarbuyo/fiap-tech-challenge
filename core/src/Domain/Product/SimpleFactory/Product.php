<?php

namespace TechChallenge\Domain\Product\SimpleFactory;

use DateTime;
use TechChallenge\Domain\Shared\ValueObjects\Price;
use TechChallenge\Domain\Category\Entities\Category;
use TechChallenge\Domain\Product\Entities\Product as ProductEntity;

class Product
{
    private ProductEntity $product;

    public function new(?string $id = null, String|DateTime $created_at = null, String|DateTime $updated_at = null): self
    {
        if (!is_null($created_at))
            $created_at = is_string($created_at) ? new DateTime($created_at) : $created_at;

        if (!is_null($updated_at))
            $updated_at = is_string($updated_at) ? new DateTime($updated_at) : $updated_at;

        $this->product = ProductEntity::create($id, $created_at, $updated_at);

        return $this;
    }

    public function withCategory(Category $category): self
    {
        $this->product
            ->setCategory($category);

        return $this;
    }

    public function withNameDescriptionPriceImage($name, $description, $price, $image): self
    {
        $this->product
            ->setName($name)
            ->setDescription($description)
            ->setPrice(new Price($price))
            ->setImage($image);

        return $this;
    }

    public function withCategoryIdCategory(string $categoryId, Category $category): self
    {
        $this->product
            ->setCategoryId($categoryId)
            ->setCategory($category);

        return $this;
    }

    public function withCategoryId(?string $categoryId): self
    {
        $this->product->setCategoryId($categoryId);

        return $this;
    }

    public function withCategoryIdNameDescriptionPrice(?string $categoryId, string $name, string $description, float $price): self
    {
        $this->product
            ->setName($name)
            ->setDescription($description)
            ->setPrice(new Price($price));

        if ($categoryId)
            $this->product->setCategoryId($categoryId);

        return $this;
    }

    public function build(): ProductEntity
    {
        return $this->product;
    }
}
