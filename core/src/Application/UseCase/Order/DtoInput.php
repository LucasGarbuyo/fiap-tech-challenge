<?php

namespace TechChallenge\Application\UseCase\Order;

use TechChallenge\Domain\Order\UseCase\DtoInput as IOrderUseCaseDtoInput;

class DtoInput implements IOrderUseCaseDtoInput
{
    public $id;
    public $customer_id;
    public $items;
    public $status;
    public $total;

    public function __construct(
        ?string $id = null,
        ?string $customer_id = null,
        ?array $items = null,
    ) {
        $this->id = $id;
        $this->customer_id = $customer_id;
        $this->items = $items;
    }

    public function getId(): string|null
    {
        return $this->id;
    }

    public function getCustomerId(): string|null
    {
        return $this->customer_id;
    }

    public function getItems(): array|null
    {
        return $this->items;
    }
}
