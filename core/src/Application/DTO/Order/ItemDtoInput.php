<?php

namespace TechChallenge\Application\UseCase\Order;

use TechChallenge\Domain\Order\UseCase\ItemDtoInput as IOrderUseCaseItemDtoInput;

class ItemDtoInput implements IOrderUseCaseItemDtoInput
{
    public function __construct(
        public readonly ?string $id = null,
        public readonly ?string $product_id = null,
        public readonly ?int $quantity = null
    ) {
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getProductId(): ?string
    {
        return $this->product_id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }
}
