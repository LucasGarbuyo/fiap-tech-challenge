<?php

namespace TechChallenge\Adapter\Driven\Infra\Repository\Order;

use Illuminate\Support\Facades\DB;
use TechChallenge\Domain\Order\Entities\Order as OrderEntity;
use TechChallenge\Domain\Order\Repository\IOrder as IOrderRepository;
use Illuminate\Database\Query\Builder;

class Repository implements IOrderRepository
{

    /** @return Customer[] */
    public function index(array $filters = [], array|bool $append = []): array
    {
        $orderData = $this->query()->get();
        dd($orderData);die;
        //parei aqui neste retorno

    }

    public function store(OrderEntity $order): void
    {
        DB::transaction(function () use ($order) {
            $this->query()
                ->insert([
                    "id" => $order->getId(),
                    "customer_id" => $order->getCustomerId(),
                    "price" => $order->getPrice(),
                    "created_at" => $order->getCreatedAt(),
                    "updated_at" => $order->getUpdatedAt(),
                ]);
            foreach ($order->getItems() as $item) {
                DB::table('orders_items')->insert([
                    'id' => $item->getId(),
                    'order_id' => $order->getId(),
                    'product_id' => $item->getProductId(),
                    'quantity' => $item->getQuantity(),
                    'price' => $item->getPrice(),
                ]);
            }
        });
    }

    protected function query(): Builder
    {
        return DB::table('orders')->whereNull('deleted_at');
    }
}
