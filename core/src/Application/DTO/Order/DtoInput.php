<?php

namespace TechChallenge\Application\DTO\Order;

class DtoInput
{
    /** @var ItemDtoInput[] */
    public array $items = [];

    public function __construct(
        public readonly ?string $id = null,
        public readonly ?string $customerId = null,
        public readonly ?string $status = null,
        $items = [],
    ) {
        $this->setItems($items);
    }

    public function setItems(array $items)
    {
        foreach ($items as $item)
            $this->items[] = new ItemDtoInput(
                $item["id"] ?? null,
                $item["product_id"] ?? null,
                $item["quantity"] ?? null
            );
    }
}
