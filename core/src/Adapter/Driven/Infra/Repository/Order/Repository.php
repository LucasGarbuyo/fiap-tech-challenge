<?php

namespace TechChallenge\Adapter\Driven\Infra\Repository\Order;

use Illuminate\Support\Facades\DB;
use TechChallenge\Domain\Order\Entities\Order as OrderEntity;
use TechChallenge\Domain\Order\Repository\IOrder as IOrderRepository;
use Illuminate\Database\Query\Builder;

class Repository implements IOrderRepository
{
    public function store(OrderEntity $order): void
    {
        DB::transaction(function () use ($order) {
            $this->query()
                ->insert([
                    "id" => $order->getId(),
                    "customer_id" => $order->getCustomerId(),
                    "created_at" => $order->getCreatedAt(),
                    "updated_at" => $order->getUpdatedAt(),
                ]);
            foreach ($order->getItems() as $item) {
                DB::table('orders_items')->insert([
                    'id' => $item->getId(),
                    'order_id' => $order->getId(),
                    'product_id' => $item->getProductId(),
                    'quantity' => $item->getQuantity(),
                ]);
            }
        });
    }

    protected function query(): Builder
    {
        return DB::table('orders')->whereNull('deleted_at');
    }
}
