<?php

namespace TechChallenge\Domain\Product\Factories;

use DateTime;
use TechChallenge\Domain\Product\ValueObjects\Price;
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

    public function withNameDescriptionPrice(string $name, string $description, float $price): self
    {
        $this->product
            ->setName($name)
            ->setDescription($description)
            ->setPrice(new Price($price));

        return $this;
    }

    public function build(): ProductEntity
    {
        return $this->product;
    }
}
