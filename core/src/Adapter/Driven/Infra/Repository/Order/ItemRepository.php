<?php

namespace TechChallenge\Adapter\Driven\Infra\Repository\Order;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use TechChallenge\Domain\Order\Entities\Item as ItemEntity;
use TechChallenge\Domain\Order\Repository\IItem as IItemRepository;
use TechChallenge\Domain\Order\Factories\Item as ItemFactory;

class ItemRepository implements IItemRepository
{
    public function index(array $filters = []): array
    {
        $itemsData = $this->filters($this->query(), $filters)->get();

        if (count($itemsData) == 0)
            return [];

        $items = [];

        $itemFactory = new ItemFactory();

        foreach ($itemsData as $itemData) {
            $items[] = $itemFactory
                ->new($itemData->id, $itemData->product_id, $itemData->order_id, $itemData->created_at, $itemData->updated_at)
                ->withQuantityPrice($itemData->quantity, $itemData->price)
                ->build();
        }

        return $items;
    }

    public function exist(array $filters = []): bool
    {
        return $this->filters($this->query(), $filters)->exists();
    }

    public function store(ItemEntity $item): void
    {
        $this->query()
            ->insert([
                "id" => $item->getId(),
                "order_id" => $item->getOrderId(),
                "product_id" => $item->getProductId(),
                "quantity" => $item->getQuantity(),
                "price" => $item->getPrice()->getValue(),
                "created_at" => $item->getCreatedAt(),
                "updated_at" => $item->getUpdatedAt()
            ]);
    }

    public function update(ItemEntity $item): void
    {
    }

    public function filters(Builder $query, array $filters = []): Builder
    {
        if (!empty($filters["id"])) {
            if (!is_array($filters["id"]))
                $filters["id"] = [$filters["id"]];

            $query->whereIn('id', $filters["id"]);
        }

        return $query;
    }

    public function query(): Builder
    {
        return DB::table('orders_items')->whereNull('deleted_at');
    }
}
