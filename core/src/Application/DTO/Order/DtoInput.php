<?php

namespace TechChallenge\Application\DTO\Order;

class DtoInput
{
    // public array $items = [];

    public function __construct(
        public readonly ?string $id = null,
        public readonly ?string $customer_id = null,
        public readonly ?string $status = null,
        // $items = [],
    ) {
        //$this->setItems($items);
    }

    /*
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
            */
}
