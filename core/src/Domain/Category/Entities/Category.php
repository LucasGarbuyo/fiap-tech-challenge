<?php

namespace TechChallenge\Domain\Category\Entities;

use TechChallenge\Domain\Category\Exceptions\CategoryException;

use DateTime;

class Category
{
    private string $name;
    private string $type;
    private DateTime $created_at;
    private DateTime $updated_at;
    private ?DateTime $deleted_at;

    public function __construct(
        private string $id,
        DateTime $created_at,
        DateTime $updated_at
    ) {
        $this
            ->setCreatedAt($created_at)
            ->setUpdatedAt($updated_at);
    }

    public static function create(?string $id = null, ?DateTime $created_at = null, ?DateTime $updated_at = null): self
    {
        return new self(
            id: $id ?? uniqid("CATE_", true),
            created_at: $created_at ?? new DateTime(),
            updated_at: $updated_at ?? new DateTime()
        );
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string|null
    {
        return $this->name;
    }

    public function setType(string $type): self
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

    public function setCreatedAt(DateTime $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->created_at;
    }

    public function setUpdatedAt(DateTime $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getUpdatedAt(): DateTime
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
            "type" => $this->getType(),
        ];

        if ($complete) {
            $return["created_at"] = $this->getCreatedAt()->format("Y-m-d H:i:s");
            $return["updated_at"] = $this->getUpdatedAt()->format("Y-m-d H:i:s");
        }
        return $return;
    }
}
