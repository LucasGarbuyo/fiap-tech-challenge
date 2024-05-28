<?php

namespace TechChallenge\Adapter\Driven\Infra\Repository\Order;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use TechChallenge\Domain\Order\Repository\IOrder as IOrderRepository;
use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;
use TechChallenge\Domain\Order\Repository\IItem as IItemRepository;
use TechChallenge\Domain\Order\Entities\Order as OrderEntity;
use TechChallenge\Domain\Order\Factories\Order as OrderFactory;
use TechChallenge\Domain\Order\Factories\Item as ItemFactory;
use TechChallenge\Domain\Customer\Factories\Customer as CustomerFactory;

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
        $ordersData = $this->query()->get();

        $orders = [];

        $OrderFactory = new OrderFactory();
        foreach ($ordersData as $orderData) {
            $OrderFactory
                ->new($orderData->id)
                ->withOrder($orderData->customer_id, $orderData->price, $orderData->status)
                ->build();

            // relacionamento com customer
            if (!empty($orderData->customer_id)) {
                $customerData = $this->CustomerRepository->show([$orderData->customer_id]);
                if ($customerData) {
                    $customer = (new CustomerFactory())
                        ->new($orderData->customer_id)
                        ->withNameCpfEmail($customerData->getName(), $customerData->getCpf(), $customerData->getEmail())
                        ->build();

                    $OrderFactory->withCustomer($customer);
                }
                // $orderItems = $this->IItemRepository->getByOrderId($orderData->id);

                // relacionamento com OrderData
                // if (!$orderItems->isEmpty()) {
                //     $items = $orderItems->map(function ($itemData) {
                //         return (new ItemFactory())
                //             ->new($itemData->getProductId(), $itemData->getQuantity(), $itemData->getPrice()->getValue(), $itemData->getId())
                //             ->build();
                //     });
                //     $OrderFactory->withItems($items->toArray());
                // }
            }

            $orders[] = $OrderFactory->build();
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

        if ($append === true || in_array("customer", $append)) {

            $itemsData = $this->queryItems()->where('order_id', $id)->get();

            $items = [];
            foreach ($itemsData as $itemData) {
                $items[] = (new ItemFactory())
                    ->new($itemData->product_id, $itemData->quantity, $itemData->price, $itemData->id)
                    ->build();
            }

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
