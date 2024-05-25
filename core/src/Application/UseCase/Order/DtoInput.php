<?php

namespace TechChallenge\Application\UseCase\Order;

use TechChallenge\Domain\Order\UseCase\DtoInput as IOrderUseCaseDtoInput;

class DtoInput implements IOrderUseCaseDtoInput
{
    public readonly string $customerId;
    public readonly array $items;

    public function __construct(
        string $customerId,
        array $items,
    ) {
        $this->customerId = $customerId;
        $this->items = $items;
    }

    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    public function getItems(): array
    {
        return $this->items;
    }
}
