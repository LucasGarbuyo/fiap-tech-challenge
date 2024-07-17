<?php

namespace TechChallenge\Application\DTO\Order;

class ItemDtoInput
{
    public function __construct(
        public readonly ?string $id = null,
        public readonly ?string $productId = null,
        public readonly ?int $quantity = null
    ) {
    }
}
