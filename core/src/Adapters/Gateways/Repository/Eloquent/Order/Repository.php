<?php

namespace TechChallenge\Adapters\Gateways\Repository\Eloquent\Order;

use TechChallenge\Domain\Order\Repository\IOrder as IOrderRepository;
use TechChallenge\Domain\Order\DAO\IOrder as IOrderDAO;
use TechChallenge\Adapters\Gateways\Repository\Eloquent\Abstract\Repository as AbstractRepository;
use TechChallenge\Domain\Order\Entities\Order as OrderEntity;
use TechChallenge\Domain\Order\Entities\Item as ItemEntity;
use TechChallenge\Domain\Order\Entities\Status as StatusEntity;
use TechChallenge\Domain\Customer\Entities\Customer as CustomerEntity;
use TechChallenge\Domain\Order\SimpleFactory\Order as SimpleFactoryOrder;
use TechChallenge\Domain\Order\SimpleFactory\Item as SimpleFactoryItem;
use TechChallenge\Domain\Customer\SimpleFactory\Customer as SimpleFactoryCustomer;
use TechChallenge\Adapters\Presenters\Order\ToArray as OrderToArray;
use TechChallenge\Domain\Order\SimpleFactory\Status as SimpleFactoryStatus;

class Repository extends AbstractRepository implements IOrderRepository
{
    private readonly SimpleFactoryOrder $SimpleFactoryOrder;

    private readonly SimpleFactoryItem $SimpleFactoryItem;

    private readonly SimpleFactoryCustomer $SimpleFactoryCustomer;

    private readonly SimpleFactoryStatus $SimpleFactoryStatus;

    private readonly OrderToArray $OrderToArray;

    public function __construct(private readonly IOrderDAO $OrderDAO)
    {
        $this->SimpleFactoryOrder = new SimpleFactoryOrder();

        $this->SimpleFactoryItem = new SimpleFactoryItem();

        $this->SimpleFactoryCustomer = new SimpleFactoryCustomer();

        $this->SimpleFactoryStatus = new SimpleFactoryStatus();

        $this->OrderToArray = new OrderToArray();
    }

    public function index(array $filters = [], array|bool $append = []): array
    {
        $results = $this->OrderDAO->index($filters, $append);

        if ($this->isPaginated($results)) {
            $results["data"] = $this->toEntities($results["data"]);
        } else {
            $results = $this->toEntities($results);
        }
        return $results;
    }

    public function store(OrderEntity $order): void
    {
        $this->OrderDAO->store($this->OrderToArray->execute($order));
    }

    public function show(array $filters = [], array|bool $append = []): ?OrderEntity
    {
        $order = $this->OrderDAO->show($filters, $append);

        if (is_null($order))
            return null;

        return $this->toEntity($order);
    }

    public function update(OrderEntity $order): void
    {
        $this->OrderDAO->update($this->OrderToArray->execute($order));
    }

    public function delete(OrderEntity $order): void
    {
        $this->OrderDAO->delete($this->OrderToArray->execute($order));
    }

    protected function toEntity(array $order): OrderEntity
    {
        $this->SimpleFactoryOrder
            ->new($order["id"], $order["total"], $order["created_at"], $order["updated_at"])
            ->withCustomerId($order["customer_id"])
            ->withStatus($order["status"]);

        if (isset($order["customer_id"]) && isset($order["customer"]["id"])) {
            $customer = $this->createCustomerEntity($order["customer"]);

            $this->SimpleFactoryOrder->withCustomer($customer);
        }

        if (isset($order["items"]) && count($order["items"]) > 0) {
            $items = $this->createItemsEntity($order["items"]);

            $this->SimpleFactoryOrder->withItems($items);
        }

        if (isset($order["status_history"]) && count($order["status_history"]) > 0) {
            $status = $this->createStatusHistoriesEntity($order["status_history"]);

            $this->SimpleFactoryOrder->withStatusHistories($status);
        }

        return $this->SimpleFactoryOrder->build();
    }

    protected function createCustomerEntity(array $customer): CustomerEntity
    {
        return $this->SimpleFactoryCustomer
            ->restore($customer["id"], $customer["created_at"], $customer["updated_at"])
            ->withNameCpfEmail($customer["name"], $customer["cpf"], $customer["email"])
            ->build();
    }

    protected function createItemsEntity(array $items): array
    {
        $entities = [];

        foreach ($items as $item)
            $entities[] = $this->createItemEntity($item);

        return $entities;
    }

    protected function createItemEntity(array $item): ItemEntity
    {
        return $this->SimpleFactoryItem
            ->restore($item["id"], $item["product_id"], $item["order_id"], $item["created_at"], $item["updated_at"])
            ->withQuantityPrice($item["quantity"], $item["price"])
            ->build();
    }

    protected function createStatusHistoriesEntity(array $statusHistories): array
    {
        $entities = [];

        foreach ($statusHistories as $statusHistory)
            $entities[] = $this->createStatusHistoryEntity($statusHistory);

        return $entities;
    }

    protected function createStatusHistoryEntity(array $status): StatusEntity
    {
        return $this->SimpleFactoryStatus
            ->restore($status["id"], $status["order_id"], $status["status"], $status["created_at"], $status["updated_at"])
            ->build();
    }
}
