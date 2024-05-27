<?php

namespace TechChallenge\Adapter\Driven\Infra\Repository\Item;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use TechChallenge\Domain\Shared\ValueObjects\Price;
use TechChallenge\Domain\Order\Factories\Item as ItemFactory;
use TechChallenge\Domain\Order\Entities\Item as ItemEntity;
use TechChallenge\Domain\Order\Repository\IItem as IItemRepository;
use Illuminate\Support\Collection;

class Repository implements IItemRepository
{
    public function show(string $itemId): ItemEntity
    {
        $itemData = $this->query()->where('order_id', $itemId)->first();

        return (new ItemFactory())
            ->new($itemData->product_id, $itemData->quantity, $itemData->price)
            ->build();
    }

    public function getByOrderId(string $itemId): Collection
    {
        $itemsData = $this->query()->where('order_id', $itemId)->get();

        if ($itemsData->isEmpty()) {
            return collect();
        }

        $items = $itemsData->map(function ($itemData) {
          
            return (new ItemFactory())
                ->new($itemData->product_id, $itemData->quantity, $itemData->price)
                ->build();
        });

        return $items;
    }

    protected function query(): Builder
    {
        return DB::table("orders_items");
    }
}
