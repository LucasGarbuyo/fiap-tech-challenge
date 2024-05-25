<?php

namespace TechChallenge\Application\UseCase\Order;

use TechChallenge\Domain\Order\UseCase\DtoInput as IOrderUseCaseDtoInput;

class DtoInput implements IOrderUseCaseDtoInput
{
    public readonly ?string $customerId;
    public readonly ?array $items;
    public readonly string $status;
    public readonly float $total;

    public function __construct(
        ?string $customerId = null,
        ?array $items = null,
    ) {
        $this->customerId = $customerId;
        $this->items = $items;
    }

    public function getCustomerId(): string|null
    {
        return $this->customerId;
    }

    public function getItems(): array|null
    {
        return $this->items;
    }
}
