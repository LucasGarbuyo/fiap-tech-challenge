<?php

namespace TechChallenge\Domain\Order\Repository;

use TechChallenge\Domain\Order\Entities\Item;

interface IItem
{
    public function show(string $id): Item;
}
