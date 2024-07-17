<?php

namespace TechChallenge\Application\UseCase\Order;

use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Domain\Customer\Exceptions\CustomerNotFoundException;
use TechChallenge\Domain\Order\Repository\IOrder as IOrderRepository;
use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;
use TechChallenge\Domain\Order\Enum\OrderStatus;
use TechChallenge\Domain\Order\Exceptions\OrderException;
use TechChallenge\Domain\Order\Exceptions\OrderNotFoundException;
use TechChallenge\Domain\Product\Exceptions\ProductNotFoundException;
use TechChallenge\Application\DTO\Order\DtoInput;
use TechChallenge\Domain\Order\DAO\IOrder as IOrderDAO;
use TechChallenge\Domain\Customer\DAO\ICustomer as ICustomerDAO;
use TechChallenge\Domain\Product\DAO\IProduct as IProductDAO;
use TechChallenge\Domain\Order\SimpleFactory\Item as SimpleFactoryOrderItem;

final class Update
{
    private readonly IOrderDAO $OrderDAO;

    private readonly ICustomerDAO $CustomerDAO;

    private readonly IProductDAO $ProductDAO;

    private readonly IOrderRepository $OrderRepository;

    private readonly IProductRepository $ProductRepository;

    public function __construct(AbstractFactoryRepository $AbstractFactoryRepository)
    {
        $this->OrderDAO = $AbstractFactoryRepository->getDAO()->createOrderDAO();

        $this->CustomerDAO = $AbstractFactoryRepository->getDAO()->createCustomerDAO();

        $this->ProductDAO = $AbstractFactoryRepository->getDAO()->createProductDAO();

        $this->OrderRepository = $AbstractFactoryRepository->createOrderRepository();

        $this->ProductRepository = $AbstractFactoryRepository->createProductRepository();
    }

    public function execute(DtoInput $dto): void
    {
        if (!$dto->id || !$this->OrderDAO->exist(["id" => $dto->id]))
            throw new OrderNotFoundException();

        $order = $this->OrderRepository->show(["id" => $dto->id], true);

        if ($order->getStatus() != OrderStatus::NEW)
            throw new OrderException("Só é possível alterar pedidos novos", 400);

        if ($order->getCustomerId() != $dto->customerId && !$dto->customerId) {
            if (!$this->CustomerDAO->exist(["id" => $dto->customerId]))
                throw new CustomerNotFoundException();

            $order->setCustomerId($dto->customerId);
        }

        $idsProducts = [];

        $SimpleFactoryOrderItem = new SimpleFactoryOrderItem();

        foreach ($dto->items as $item) {

            if (!$item->productId || !$this->ProductDAO->exist(["id" => $item->productId]))
                throw new ProductNotFoundException();

            $product = $this->ProductRepository->show(["id" => $item->productId]);

            $item = $SimpleFactoryOrderItem
                ->new(null, $product->getId(), $order->getId())
                ->withQuantityPrice($item->quantity, $product->getPrice()->getValue())
                ->build();

            $idsProducts[] = $item->getProductId();

            $order->setItem($item);
        }

        $order->removeItemsByProductIdsNotIn($idsProducts);

        $order->calcTotal();

        $this->OrderRepository->update($order);
    }
}
