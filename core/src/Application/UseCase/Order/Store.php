<?php

namespace TechChallenge\Application\UseCase\Order;

use TechChallenge\Domain\Order\Exceptions\OrderNotFoundException;
use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Domain\Order\Factories\{Order as OrderFactory, Item as ItemFactory};
use TechChallenge\Domain\Order\SimpleFactory\Order as FactorySimpleOrder;
use TechChallenge\Application\DTO\Order\{DtoInput, Store as IOrderUseCaseStore};
use TechChallenge\Domain\Order\DAO\IOrder as IOrderDAO;
use TechChallenge\Domain\Order\Repository\IOrder as IOrderRepository;

final class Store
{
    private readonly IOrderDAO $OrderDAO;

    private readonly IOrderRepository $OrderRepository;

    public function __construct(AbstractFactoryRepository $AbstractFactoryRepository)
    {
        $this->OrderDAO = $AbstractFactoryRepository->getDAO()->createOrderDAO();

        $this->OrderRepository = $AbstractFactoryRepository->createOrderRepository();
    }

    public function execute(DtoInput $data): string
    {
        $order = (new FactorySimpleOrder())
            ->new()
            ->build();
          
        if (!is_null($data->getCustomerId())) {
            if (!$this->OrderRepository->exist(["id" => $data->getCustomerId()]))
                throw new OrderNotFoundException();

            $order->setCustomerId($data->getCustomerId());
        }

        if (!empty($data->getItems())) {
            $items = [];

            foreach ($data->getItems() as $item) {

                if (is_null($item->getProductId()) || !$this->ProductRepository->exist(["id" => $item->getProductId()]))
                    throw new ProductNotFoundException();

                $product = $this->ProductRepository->show(["id" => $item->getProductId()]);

                $items[] = (new ItemFactory())
                    ->new(id: null, product_id: $product->getId(), order_id: $order->getId())
                    ->withQuantityPrice($item->getQuantity(), $product->getPrice()->getValue())
                    ->build();
            }

            $order->setItems($items);
        }

        $order->calcTotal();

        $order->setAsNew();

        $this->OrderRepository->store($order);

        return $order->getId();
    }
}
