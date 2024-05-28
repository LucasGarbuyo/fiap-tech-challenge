<?php

namespace TechChallenge\Domain\Order\Factories;

use DateTime;
use TechChallenge\Domain\Order\Entities\Item as ItemEntity;
use TechChallenge\Domain\Shared\ValueObjects\Price;

class Item
{
    private ItemEntity $item;

    public function new(?string $id = null, String|DateTime $created_at = null, String|DateTime $updated_at = null): self
    {
        if (!is_null($created_at))
            $created_at = is_string($created_at) ? new DateTime($created_at) : $created_at;

        if (!is_null($updated_at))
            $updated_at = is_string($updated_at) ? new DateTime($updated_at) : $updated_at;

        $this->item = ItemEntity::create($id, $created_at, $updated_at);

        return $this;
    }

    public function withProductIdQuantityPrice($product_id, $quantity, $price): self
    {
        $this->item
            ->setProductId($product_id)
            ->setQuantity($quantity)
            ->setPrice(new Price($price));

        return $this;
    }

    public function build(): ItemEntity
    {
        return $this->item;
    }
}
