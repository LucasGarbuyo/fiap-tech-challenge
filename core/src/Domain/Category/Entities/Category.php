<?php

namespace TechChallenge\Domain\Category\Entities;

use TechChallenge\Domain\Shared\Entities\Standard as StandardEntity;
use TechChallenge\Domain\Category\Exceptions\CategoryException;

class Category extends StandardEntity
{
    protected static string $idPrefix = "CATE";

    private string $name;

    private ?string $type;

    public function setName(string|null $name): self
    {
        if (strlen($name) < 3)
            throw new CategoryException("Nome da categoria deve ter 3 ou mais caracteres");

        $this->name = $name;

        return $this;
    }

    public function getName(): string|null
    {
        return $this->name;
    }

    public function setType(string|null $type): self
    {
        if (strlen($type) > 11)
            throw new CategoryException("A categoria não pode haver mais de 12 caracteres!");

        $this->type = $type;

        return $this;
    }

    public function getType(): string|null
    {
        return $this->type;
    }
}
