<?php

namespace TechChallenge\Application\UseCase\Order;

use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Domain\Order\Exceptions\OrderException;
use TechChallenge\Domain\Order\Exceptions\OrderNotFoundException;
use TechChallenge\Domain\Order\Repository\IOrder as IOrderRepository;
use TechChallenge\Domain\Order\DAO\IOrder as IOrderDAO;

final class Checkout
{
    private readonly IOrderDAO $OrderDAO;

    private  readonly IOrderRepository $OrderRepository;

    public function __construct(AbstractFactoryRepository $AbstractFactoryRepository)
    {
        $this->OrderDAO = $AbstractFactoryRepository->getDAO()->createOrderDAO();

        $this->OrderRepository = $AbstractFactoryRepository->createOrderRepository();
    }

    public function execute(?string $id): void
    {
        if (!$id || !$this->OrderDAO->exist(["id" => $id]))
            throw new OrderNotFoundException();

        $order = $this->OrderRepository->show(["id" => $id], true);

        if (!$order->isNew())
            throw new OrderException("Não pode ser processado pois o pedido já foi pago", 400);

        if (count($order->getItems()) == 0)
            throw new OrderException("Não pode ser processado pois não há itens no carrinho", 400);

        $order
            ->setAsReceived()
            ->setAsPaid();

        $this->OrderRepository->update($order);
    }
}
