<?php

namespace TechChallenge\Domain\Order\Repository;

use TechChallenge\Domain\Order\Entities\Item;
use Illuminate\Support\Collection;

interface IItem
{
    public function show(string $id): Item;

    public function getByOrderId(string $orderId): Collection;
}
