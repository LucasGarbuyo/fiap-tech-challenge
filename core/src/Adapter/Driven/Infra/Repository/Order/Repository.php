<?php

namespace TechChallenge\Adapter\Driven\Infra\Repository\Order;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use TechChallenge\Domain\Order\Repository\IOrder as IOrderRepository;
use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;
use TechChallenge\Domain\Order\Repository\IItem as IItemRepository;
use TechChallenge\Domain\Order\Entities\Order as OrderEntity;
use TechChallenge\Domain\Order\Factories\Order as OrderFactory;

class Repository implements IOrderRepository
{
    public function __construct(
        protected readonly ICustomerRepository $CustomerRepository,
        protected readonly IItemRepository $ItemRepository
    ) {
    }

    /** @return Order[] */
    public function index(array $filters = [], array|bool $append = []): array
    {
        $ordersData = $this->filters($this->query($append), $filters)->get();

        $orders = [];

        $orderFactory = new OrderFactory();

        foreach ($ordersData as $orderData) {
            $orderFactory
                ->new($orderData->id, $orderData->total, $orderData->created_at, $orderData->updated_at);

            if (($append === true || in_array("customer", $append)) && !empty($orderData->customer_id)) {

                $customer = $this->CustomerRepository->show(["id" => $orderData->customer_id]);

                if (!empty($customer))
                    $orderFactory->withCustomerIdCustomer($orderData->customer_id, $customer);
            }

            if ($append === true || in_array("items", $append)) {

                $items = $this->ItemRepository->index(["order_id" => $orderData->id]);

                $orderFactory->withItems($items);
            }

            $orders[] = $orderFactory->build();
        }

        return $orders;
    }

    public function show(array $filters = [], array|bool $append = []): OrderEntity|null
    {
        $orderData = $this->filters($this->query($append), $filters)->first();

        if (empty($orderData))
            return null;

        $orderFactory = (new OrderFactory())
            ->new($orderData->id, $orderData->total, $orderData->created_at, $orderData->updated_at);

        if (($append === true || in_array("customer", $append)) && !empty($orderData->customer_id)) {

            $customer = $this->CustomerRepository->show(["id" => $orderData->customer_id]);

            if (!empty($customer))
                $orderFactory->withCustomerIdCustomer($orderData->customer_id, $customer);
        }

        if ($append === true || in_array("items", $append)) {

            $items = $this->ItemRepository->index(["order_id", $orderData->id]);

            $orderFactory->withItems($items);
        }

        return $orderFactory->build();
    }

    public function store(OrderEntity $order): void
    {
        DB::transaction(function () use ($order) {
            $this->query()
                ->insert([
                    "id" => $order->getId(),
                    "customer_id" => $order->getCustomerId(),
                    "total" => $order->getTotal()->getValue(),
                    "status" => $order->getStatus(),
                    "created_at" => $order->getCreatedAt(),
                    "updated_at" => $order->getUpdatedAt(),
                ]);

            foreach ($order->getItems() as $item)
                $this->ItemRepository->store($item);
        });
    }

    public function update(OrderEntity $order): void
    {
        DB::transaction(function () use ($order) {
            $this->query()
                ->insert([
                    "id" => $order->getId(),
                    "customer_id" => $order->getCustomerId(),
                    "total" => $order->getTotal()->getValue(),
                    "status" => $order->getStatus(),
                    "created_at" => $order->getCreatedAt(),
                    "updated_at" => $order->getUpdatedAt(),
                ]);

            foreach ($order->getItems() as $item) {
                $this->queryItems()
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
        });
    }

    public function delete(OrderEntity $order): void
    {
        $this->filters($this->query(), ["id" => $order->getId()])
            ->update(
                [
                    "deleted_at" => $order->getDeletedAt()->format("Y-m-d H:i:s")
                ]
            );
    }

    public function exist(array $filters = []): bool
    {
        return $this->filters($this->query(), $filters)->exists();
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

    public function query(array|bool $append = []): Builder
    {
        return DB::table('orders')->whereNull('deleted_at');
    }
}
