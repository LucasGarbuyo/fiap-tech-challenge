<?php

namespace TechChallenge\Domain\Category\SimpleFactory;

use DateTime;
use TechChallenge\Domain\Category\Entities\Category as CategoryEntity;

class Category
{
    private CategoryEntity $category;

    public function new(?string $id = null, String|DateTime $createdAt = null, String|DateTime $updatedAt = null): self
    {
        if (!is_null($createdAt))
            $createdAt = is_string($createdAt) ? new DateTime($createdAt) : $createdAt;

        if (!is_null($updatedAt))
            $updatedAt = is_string($updatedAt) ? new DateTime($updatedAt) : $updatedAt;

        $this->category = CategoryEntity::create($id, $createdAt, $updatedAt);

        return $this;
    }

    public function restore(?string $id = null, String|DateTime $createdAt = null, String|DateTime $updatedAt = null): self
    {
        if (!is_null($createdAt))
            $createdAt = is_string($createdAt) ? new DateTime($createdAt) : $createdAt;

        if (!is_null($updatedAt))
            $updatedAt = is_string($updatedAt) ? new DateTime($updatedAt) : $updatedAt;


        $this->category = new CategoryEntity($id, $createdAt, $updatedAt);

        return $this;
    }

    public function withNameType($name, $type): self
    {
        $this->category
            ->setName($name)
            ->setType($type);

        return $this;
    }

    public function build(): CategoryEntity
    {
        return $this->category;
    }
}
