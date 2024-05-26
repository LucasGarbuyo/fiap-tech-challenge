<?php

namespace TechChallenge\Adapter\Driven\Infra\Repository\Order;

use Illuminate\Support\Facades\DB;
use TechChallenge\Domain\Order\Entities\Order as OrderEntity;
use TechChallenge\Domain\Order\Repository\IOrder as IOrderRepository;
use Illuminate\Database\Query\Builder;
use TechChallenge\Config\DIContainer;
use TechChallenge\Domain\Order\Exceptions\OrderNotFoundException;
use TechChallenge\Domain\Order\Factories\Order as OrderFactory;
use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;
use TechChallenge\Domain\Order\Factories\Item as ItemFactory;
use TechChallenge\Domain\Shared\ValueObjects\Price;

class Repository implements IOrderRepository
{

    /** @return Order[] */
    public function index(array $filters = [], array|bool $append = []): array
    {
        $ordersData = $this->query()->get();
        $OrderFactory = new OrderFactory();

        $orders = [];
        foreach ($ordersData as $orderData) {
            $OrderFactory
                ->new()
                ->withIdCustomerId($orderData->id, $orderData->customer_id)
                ->build();

            $orders[] = $OrderFactory->build();
        }



        return $orders;
    }

    public function show(string $id): OrderEntity
    {
        $orderData = $this->query()->where('id', $id)->first();

        if (empty($orderData))
            throw new OrderNotFoundException('Not found', 404);

        $orderFactory = (new OrderFactory())
            ->new($orderData->id, $orderData->created_at, $orderData->updated_at);

        $customerRepository = DIContainer::create()->get(ICustomerRepository::class);

        if ($orderData->customer_id) {
            $customer = $customerRepository->show([$orderData->customer_id]);
            $orderFactory->withCustomer($customer);
        }

        $itemsData = $this->queryItems()->where('order_id', $id)->get();
        $items = [];
        foreach ($itemsData as $itemData) {
            $items[] = (new ItemFactory())
                ->new($itemData->product_id, $itemData->quantity, new Price($itemData->price), $itemData->id)
                ->build();
        }
        return $orderFactory->withItems($items)->build();
    }

    public function store(OrderEntity $order): void
    {
        DB::transaction(function () use ($order) {
            $this->query()
                ->insert([
                    "id" => $order->getId(),
                    "customer_id" => $order->getCustomerId(),
                    "price" => $order->getPrice(),
                    "status" => $order->getStatus(),
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

    public function delete(OrderEntity $order): void
    {
        $this->query()
            ->where('id', $order->getId())
            ->update(
                [
                    "deleted_at" => $order->getDeletedAt()->format("Y-m-d H:i:s")
                ]
            );
    }

    protected function query(): Builder
    {
        return DB::table('orders')->whereNull('deleted_at');
    }

    protected function queryItems(): Builder
    {
        return DB::table('orders_items');
    }
}
