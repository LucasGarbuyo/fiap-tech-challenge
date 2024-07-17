<?php

namespace TechChallenge\Application\DTO\Product;

class DtoInput
{
    public function __construct(
        public readonly ?string $id          = null,
        public readonly ?string $categoryId  = null,
        public readonly ?string $name        = null,
        public readonly ?string $description = null,
        public readonly ?string $price       = null,
        public readonly ?string $image       = null,
        public readonly ?string $createdAt   = null,
        public readonly ?string $updatedAt   = null,
    ) {
    }
}
