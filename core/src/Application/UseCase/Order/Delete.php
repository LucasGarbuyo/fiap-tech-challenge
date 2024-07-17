<?php

namespace TechChallenge\Application\UseCase\Order;

use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Domain\Order\Exceptions\OrderException;
use TechChallenge\Domain\Order\Exceptions\OrderNotFoundException;
use TechChallenge\Domain\Order\Repository\IOrder as IOrderRepository;
use TechChallenge\Domain\Order\DAO\IOrder as IOrderDAO;

final class Delete
{
    private readonly IOrderRepository $OrderRepository;

    private readonly IOrderDAO $OrderDAO;

    public function __construct(AbstractFactoryRepository $AbstractFactoryRepository)
    {
        $this->OrderRepository = $AbstractFactoryRepository->createOrderRepository();

        $this->OrderDAO = $AbstractFactoryRepository->getDAO()->createOrderDAO();
    }

    public function execute(?string $id): void
    {
        if (!$id || !$this->OrderDAO->exist(["id" => $id]))
            throw new OrderNotFoundException();

        $order = $this->OrderRepository->show(["id" => $id], true);

        if (!$order->isNew())
            throw new OrderException("Não pode excluir um pedido que não seja novo", 400);

        $order->delete();

        $this->OrderRepository->delete($order);
    }
}
