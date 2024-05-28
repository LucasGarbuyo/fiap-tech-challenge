<?php

namespace TechChallenge\Domain\Order\Repository;

use TechChallenge\Domain\Order\Entities\Item;

interface IItem
{
    public function index(array $filters = []): array;

    public function exist(array $filters = []): bool;

    public function store(Item $item): void;

    public function update(Item $item): void;
}
