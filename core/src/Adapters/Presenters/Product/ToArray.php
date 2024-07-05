<?php

namespace TechChallenge\Adapters\Presenters\Product;

use TechChallenge\Adapters\Presenters\Traits\ExecuteOnArray as ExecuteOnArrayTrait;
use TechChallenge\Domain\Product\Entities\Product as ProductEntity;

class ToArray
{
    use ExecuteOnArrayTrait;

    public function execute(ProductEntity $product): array
    {
        return [
            "id" => $product->getId(),
            "name" => $product->getName(),
            "description" => $product->getDescription(),
            "price" => $product->getPrice()->getValue(),
            "image" => $product->getImage(),
            "category_id" => $product->getCategoryId(),
            // "category" => $product->getCategory() ? $product->getCategory()->toArray() : [], TODO fazer o append da categoria
            "created_at" => $product->getCreatedAt() ? $product->getCreatedAt()->format("Y-m-d H:i:s") : null,
            "updated_at" => $product->getUpdatedAt() ? $product->getUpdatedAt()->format("Y-m-d H:i:s") : null
        ];
    }
}
