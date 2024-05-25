<?php

namespace TechChallenge\Application\UseCase\Order;

use TechChallenge\Domain\Order\UseCase\DtoInput as IOrderUseCaseDtoInput;

class DtoInput implements IOrderUseCaseDtoInput
{
    public readonly ?string $id;
    public readonly ?string $customerId;
    public readonly ?array $items;
    public readonly string $status;
    public readonly float $total;

    public function __construct(
        ?string $id = null,
        ?string $customerId = null,
        ?array $items = null,
    ) {
        $this->id = $id;
        $this->customerId = $customerId;
        $this->items = $items;
    }

    public function getId(): string|null
    {
        return $this->id;
    }

    public function getCustomerId(): string|null
    {
        return $this->customerId;
    }

    public function getItems(): array
    {
        return $this->items;
    }
}
