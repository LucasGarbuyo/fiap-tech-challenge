<?php

namespace TechChallenge\Application\UseCase\Order;

use TechChallenge\Domain\Customer\Exceptions\CustomerNotFoundException;
use TechChallenge\Domain\Order\UseCase\{DtoInput, Update as IOrderUseCaseUpdate};
use TechChallenge\Domain\Order\Repository\IOrder as IOrderRepository;
use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;
use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;
use TechChallenge\Domain\Order\Enum\OrderStatus;
use TechChallenge\Domain\Order\Exceptions\InvalidStatusOrder;
use TechChallenge\Domain\Order\Exceptions\OrderException;
use TechChallenge\Domain\Order\Exceptions\OrderNotFoundException;
use TechChallenge\Domain\Product\Exceptions\ProductNotFoundException;
use TechChallenge\Domain\Order\Factories\Item as ItemFactory;

use ValueError;

class Update implements IOrderUseCaseUpdate
{
    public function __construct(
        protected readonly IOrderRepository $OrderRepository,
        protected readonly IProductRepository $ProductRepository,
        protected readonly ICustomerRepository $CustomerRepository
    ) {
    }

    public function execute(DtoInput $data): void
    {
        if (is_null($data->getId()) || !$this->OrderRepository->exist(["id" => $data->getId()]))
            throw new OrderNotFoundException();

        $order = $this->OrderRepository->show(["id" => $data->getId()], true);

        if ($order->getStatus() != OrderStatus::NEW)
            throw new OrderException("Pedido não está aberto, não pode ser alterado", 400);

        if ($order->getCustomerId() != $data->getCustomerId() && !is_null($data->getCustomerId())) {
            if (!$this->CustomerRepository->exist(["id" => $data->getCustomerId()]))
                throw new CustomerNotFoundException();

            $order->setCustomerId($data->getCustomerId());
        }

        $idsProducts = [];

        foreach ($data->getItems() as $item) {

            if (is_null($item->getProductId()))
                continue;

            if (!$this->ProductRepository->exist(["id" => $item->getProductId()]))
                throw new ProductNotFoundException();

            $product = $this->ProductRepository->show(["id" => $item->getProductId()]);

            $item = (new ItemFactory())
                ->new(id: null, product_id: $product->getId(), order_id: $order->getId())
                ->withQuantityPrice($item->getQuantity(), $product->getPrice()->getValue())
                ->build();

            $idsProducts[] = $item->getProductId();

            $order->setItem($item);
        }

        $order->removeItemsByProductIdsNotIn($idsProducts);

        $order->calcTotal();

        $this->OrderRepository->update($order);
    }
}
