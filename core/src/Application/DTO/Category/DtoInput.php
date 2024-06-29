<?php

namespace TechChallenge\Application\DTO\Category;

class DtoInput
{
    public function __construct(
        public readonly ?string $id = null,
        public readonly ?string $name = null,
        public readonly ?string $type = null,
        public readonly ?string $createdAt = null,
        public readonly ?string $updatedAt = null
    ) {
    }
}
