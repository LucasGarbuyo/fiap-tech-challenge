<?php

namespace TechChallenge\Adapters\Presenters\Category;

use TechChallenge\Adapters\Presenters\Traits\ExecuteOnArray as ExecuteOnArrayTrait;
use TechChallenge\Domain\Category\Entities\Category as CategoryEntity;

class ToArray
{
    use ExecuteOnArrayTrait;

    public function execute(CategoryEntity $category): array
    {
        return [
            "id" => $category->getId(),
            "name" => $category->getName(),
            "type" => $category->getType(),
            "created_at" => $category->getCreatedAt() ? $category->getCreatedAt()->format("Y-m-d H:i:s") : null,
            "updated_at" => $category->getUpdatedAt() ? $category->getUpdatedAt()->format("Y-m-d H:i:s") : null,
            "deleted_at" => $category->getDeletedAt() ? $category->getDeletedAt()->format("Y-m-d H:i:s") : null,
        ];
    }
}
