<?php

namespace TechChallenge\Domain\Order\Factories;

use DateTime;
use TechChallenge\Domain\Order\Entities\Item as ItemEntity;

class Item
{
    private ItemEntity $item;

    public function new(
        ?string $id = null,
        string $productId,
        int $quantity,
        String|DateTime $created_at = null,
        String|DateTime $updated_at = null
    ): self {
        if (!is_null($created_at))
            $created_at = is_string($created_at) ? new DateTime($created_at) : $created_at;

        if (!is_null($updated_at))
            $updated_at = is_string($updated_at) ? new DateTime($updated_at) : $updated_at;

        $this->item = ItemEntity::create($id, $productId, $quantity, $created_at, $updated_at);

        return $this;
    }
}
