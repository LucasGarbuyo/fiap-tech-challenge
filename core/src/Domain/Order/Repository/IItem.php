<?php

namespace TechChallenge\Domain\Order\Repository;

use TechChallenge\Domain\Order\Entities\{Item, Order};

interface IItem
{
    public function exist(array $filters = []): bool;

    public function store(Item $item, Order $order): void;

    public function update(Item $item): void;
}
