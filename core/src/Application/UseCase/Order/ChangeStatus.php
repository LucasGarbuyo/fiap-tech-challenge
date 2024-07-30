<?php

namespace TechChallenge\Application\UseCase\Order;

use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Domain\Order\Enum\OrderStatus;
use TechChallenge\Domain\Order\Exceptions\InvalidStatusOrder;
use TechChallenge\Domain\Order\Exceptions\OrderException;
use TechChallenge\Domain\Order\Exceptions\OrderNotFoundException;
use TechChallenge\Domain\Order\Repository\IOrder as IOrderRepository;
use TechChallenge\Domain\Order\DAO\IOrder as IOrderDAO;
use ValueError;

final class ChangeStatus
{
    private readonly IOrderDAO $OrderDAO;

    private readonly IOrderRepository $OrderRepository;

    public function __construct(AbstractFactoryRepository $AbstractFactoryRepository)
    {
        $this->OrderDAO =  $AbstractFactoryRepository->getDAO()->createOrderDAO();

        $this->OrderRepository = $AbstractFactoryRepository->createOrderRepository();
    }

    public function execute(?string $id, ?string $status): void
    {
        if (!$id || !$this->OrderDAO->exist(["id" => $id]))
            throw new OrderNotFoundException();

        $order = $this->OrderRepository->show(["id" => $id], true);

        try {
            $status = OrderStatus::from($status);
        } catch (ValueError $error) {
            throw new InvalidStatusOrder();
        }

        if ($status === OrderStatus::IN_PREPARATION) {
            $order->setAsInPreparation();
        } else if ($status === OrderStatus::READY) {
            $order->setAsReady();
        } else if ($status === OrderStatus::FINISHED) {
            $order->setAsFinished();
        } else if ($status === OrderStatus::CANCELED) {
            $order->setAsCanceled();
        } else {
            throw new OrderException("Não é possível alterar o pedido para esse status {$status->value}");
        }

        $this->OrderRepository->update($order);
    }
}
