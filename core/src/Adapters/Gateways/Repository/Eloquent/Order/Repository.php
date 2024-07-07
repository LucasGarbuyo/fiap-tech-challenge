<?php

namespace TechChallenge\Adapters\Gateways\Repository\Eloquent\Order;

use TechChallenge\Domain\Order\Repository\IOrder as IOrderRepository;
use TechChallenge\Domain\Order\DAO\IOrder as IOrderDAO;
use TechChallenge\Adapters\Gateways\Repository\Eloquent\Abstract\Repository as AbstractRepository;
use TechChallenge\Domain\Order\Entities\{Order as OrderEntity, Item as ItemEntity};
use TechChallenge\Domain\Customer\Entities\Customer as CustomerEntity;
use TechChallenge\Domain\Order\SimpleFactory\{Order as SimpleFactoryOrder, Item as SimpleFactoryItem};
use TechChallenge\Domain\Customer\SimpleFactory\Customer as SimpleFactoryCustomer;
use TechChallenge\Adapters\Presenters\Order\ToArray as OrderToArray;

class Repository extends AbstractRepository implements IOrderRepository
{
    private readonly SimpleFactoryOrder $SimpleFactoryOrder;

    private readonly SimpleFactoryItem $SimpleFactoryItem;

    private readonly SimpleFactoryCustomer $SimpleFactoryCustomer;

    private readonly OrderToArray $OrderToArray;

    public function __construct(private readonly IOrderDAO $OrderDAO)
    {
        $this->SimpleFactoryOrder = new SimpleFactoryOrder();

        $this->SimpleFactoryItem = new SimpleFactoryItem();

        $this->SimpleFactoryCustomer = new SimpleFactoryCustomer();

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
    }

    public function delete(OrderEntity $order): void
    {
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

        /*
        if (isset($order["status_history"])) {
            $items = $order["status_history"];
            $itemEntities = [];
            foreach ($items as $item) {
                $itemEntity = $this->createItemEntity($item);
                $this->SimpleFactoryOrder->withItems(array($itemEntity));
                if (!is_null($itemEntity)) {
                    $itemEntities[] = $itemEntity;
                }
            }
        }

        if (isset($order["status_history"])) {
            // $status = $this->createStatusHistoryEntity($order["customer"]);
            $this->SimpleFactoryOrder->withStatus($order["status_history"]);
        }*/

        return $this->SimpleFactoryOrder->build();
    }

    protected function createCustomerEntity(array $customer): ?CustomerEntity
    {
        return $this->SimpleFactoryCustomer
            ->restore($customer["id"], $customer["created_at"], $customer["updated_at"])
            ->withNameCpfEmail($customer["name"], $customer["cpf"], $customer["email"])
            ->build();
    }

    protected function createItemEntity(array $item): ?ItemEntity
    {
        return $this->SimpleFactoryItem
            ->restore($item["id"], $item["created_at"], $item["updated_at"])
            ->withQuantityPrice($item["quantity"], $item["price"])
            ->build();
    }
}
