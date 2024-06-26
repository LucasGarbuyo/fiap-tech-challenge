<?php

namespace TechChallenge\Adapter\Driven\Infra\Repository\Order;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use TechChallenge\Domain\Order\Repository\IOrder as IOrderRepository;
use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;
use TechChallenge\Domain\Order\Repository\{IItem as IItemRepository, IStatus as IStatusRepository};
use TechChallenge\Domain\Order\Entities\Order as OrderEntity;
use TechChallenge\Domain\Order\Factories\Order as OrderFactory;

class Repository implements IOrderRepository
{
    public function __construct(
        protected readonly ICustomerRepository $CustomerRepository,
        protected readonly IItemRepository $ItemRepository,
        protected readonly IStatusRepository $StatusRepository
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
                ->new($orderData->id, $orderData->total, $orderData->created_at, $orderData->updated_at)
                ->withStatus($orderData->status)
                ->withCustomerId($orderData->customer_id);

            if (($append === true || in_array("customer", $append)) && !empty($orderData->customer_id)) {

                $customer = $this->CustomerRepository->show(["id" => $orderData->customer_id]);

                if (!empty($customer))
                    $orderFactory->withCustomer($customer);
            }

            if ($append === true || in_array("items", $append)) {

                $items = $this->ItemRepository->index(["order_id" => $orderData->id]);

                $orderFactory->withItems($items);
            }

            if ($append === true || in_array("status", $append)) {

                $statusHistories = $this->StatusRepository->index(["order_id" => $orderData->id]);

                $orderFactory->withStatusHistories($statusHistories);
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
            ->new($orderData->id, $orderData->total, $orderData->created_at, $orderData->updated_at)
            ->withStatus($orderData->status)
            ->withCustomerId($orderData->customer_id);

        if (($append === true || in_array("customer", $append)) && !empty($orderData->customer_id)) {

            $customer = $this->CustomerRepository->show(["id" => $orderData->customer_id]);

            if (!empty($customer))
                $orderFactory->withCustomer($customer);
        }

        if ($append === true || in_array("items", $append)) {

            $items = $this->ItemRepository->index(["order_id" => $orderData->id]);

            $orderFactory->withItems($items);
        }

        if ($append === true || in_array("status", $append)) {

            $statusHistories = $this->StatusRepository->index(["order_id" => $orderData->id]);

            $orderFactory->withStatusHistories($statusHistories);
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

            foreach ($order->getStatusHistories() as $status)
                $this->StatusRepository->store($status);
        });
    }

    public function update(OrderEntity $order): void
    {
        DB::transaction(function () use ($order) {
            $this->filters($this->query(), ["id" => $order->getId()])
                ->update([
                    "customer_id" => $order->getCustomerId(),
                    "total" => $order->getTotal()->getValue(),
                    "status" => $order->getStatus(),
                    "created_at" => $order->getCreatedAt(),
                    "updated_at" => $order->getUpdatedAt(),
                ]);

            foreach ($order->getItems() as $item) {
                if ($this->ItemRepository->exist(["id" => $item->getId()]))
                    $this->ItemRepository->update($item);
                else
                    $this->ItemRepository->store($item);
            }

            foreach ($order->getStatusHistories() as $status) {
                if ($this->StatusRepository->exist(["id" => $status->getId()]))
                    $this->StatusRepository->update($status);
                else
                    $this->StatusRepository->store($status);
            }
        });
    }

    public function delete(OrderEntity $order): void
    {
        DB::transaction(function () use ($order) {
            $this->filters($this->query(), ["id" => $order->getId()])
                ->update(
                    [
                        "deleted_at" => $order->getDeletedAt()->format("Y-m-d H:i:s")
                    ]
                );

            foreach ($order->getItems() as $item)
                $this->ItemRepository->update($item);

            foreach ($order->getStatusHistories() as $status)
                $this->StatusRepository->update($status);
        });
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
