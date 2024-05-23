<?php

namespace TechChallenge\Domain\Category\Factories;

use DateTime;
use TechChallenge\Domain\Category\Entities\Category as CategoryEntity;

class Category
{
    private CategoryEntity $Category;

    public function new(?string $id = null, String|DateTime $created_at = null, String|DateTime $updated_at = null): self
    {
        if (!is_null($created_at))
            $created_at = is_string($created_at) ? new DateTime($created_at) : $created_at;

        if (!is_null($updated_at))
            $updated_at = is_string($updated_at) ? new DateTime($updated_at) : $updated_at;

        $this->Category = CategoryEntity::create($id, $created_at, $updated_at);

        return $this;
    }

    public function withNameType(string $name, string $type): self
    {
        $this->Category
            ->setName($name)
            ->setType($type);

        return $this;
    }

    public function build(): CategoryEntity
    {
        return $this->Category;
    }
}
