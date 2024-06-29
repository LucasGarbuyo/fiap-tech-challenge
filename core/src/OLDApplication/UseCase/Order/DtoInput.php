<?php

namespace TechChallenge\Application\UseCase\Order;

use TechChallenge\Domain\Order\UseCase\DtoInput as IOrderUseCaseDtoInput;

class DtoInput implements IOrderUseCaseDtoInput
{
    public array $items = [];

    public function __construct(
        public readonly ?string $id = null,
        public readonly ?string $customer_id = null,
        public readonly ?string $status = null,
        $items = [],
    ) {
        $this->setItems($items);
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getCustomerId(): ?string
    {
        return $this->customer_id;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setItems(array|null $items)
    {
        if (empty($items))
            return;

        foreach ($items as $item)
            $this->items[] = new ItemDtoInput(
                $item["id"] ?? null,
                $item["product_id"] ?? null,
                $item["quantity"] ?? null
            );
    }
}
