<?php

namespace TechChallenge\Application\DTO\Customer;

class DtoInput
{
    public function __construct(
        public readonly ?string $id = null,
        public readonly ?string $name = null,
        public readonly ?string $cpf = null,
        public readonly ?string $email = null,
        public readonly ?string $createdAt = null,
        public readonly ?string $updatedAt = null
    ) {
    }
}
