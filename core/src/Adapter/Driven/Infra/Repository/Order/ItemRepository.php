<?php

namespace TechChallenge\Adapter\Driven\Infra\Repository\Order;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use TechChallenge\Domain\Order\Entities\{Item as ItemEntity, Order as OrderEntity};
use TechChallenge\Domain\Order\Repository\IItem as IItemRepository;

class ItemRepository implements IItemRepository
{
    public function exist(array $filters = []): bool
    {
        return $this->filters($this->query(), $filters)->exists();
    }

    public function store(ItemEntity $item, OrderEntity $order): void
    {
        $this->query()
            ->insert([
                "id" => $item->getId(),
                "order_id" => $order->getId(),
                "product_id" => $item->getProductId(),
                "quantity" => $item->getQuantity(),
                "price" => $item->getPrice()->getValue(),
                "created_at" => $item->getCreatedAt(),
                "updated_at" => $item->getUpdatedAt(),
                "deleted_at" => $item->getDeletedAt()
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
