<?php

namespace TechChallenge\Application\UseCase\Order;

use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Domain\Order\Enum\OrderStatus;
use TechChallenge\Domain\Order\Exceptions\InvalidStatusOrder;
use TechChallenge\Domain\Order\Exceptions\OrderException;
use TechChallenge\Domain\Order\Exceptions\OrderNotFoundException;
use TechChallenge\Domain\Order\Repository\IOrder as IOrderRepository;
use TechChallenge\Domain\Order\DAO\IOrder as IOrderDAO;
use TechChallenge\Application\DTO\Order\DtoInput;
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

    public function execute(DtoInput $dto): void
    {
        if (!$dto->id || !$this->OrderDAO->exist(["id" => $dto->id]))
            throw new OrderNotFoundException();

        $order = $this->OrderRepository->show(["id" => $dto->id], true);

        if ($order->isCanceled())
            throw new OrderException("Não pode alterar o status pois o pedido foi cancelado e esse é um status final.", 400);

        if ($order->isNew() || $order->isReceived())
            throw new OrderException("Não pode alterar o status pois o pedido não está pago", 400);

        try {
            $status = OrderStatus::from($dto->status);
        } catch (ValueError $error) {
            throw new InvalidStatusOrder();
        }

        if (in_array($status, [OrderStatus::NEW, OrderStatus::RECEIVED, OrderStatus::PAID]))
            throw new OrderException("Não pode alterar o status para novo, recebido ou pago", 400);

        if ($status === $order->getStatus())
            throw new OrderException("Não pode alterar o status para o mesmo status", 400);

        if ($status === OrderStatus::IN_PREPARATION) {
            $order->setAsInPreparation();
        } else if ($status === OrderStatus::READY) {
            $order->setAsReady();
        } else if ($status === OrderStatus::FINISHED) {
            $order->setAsFinished();
        } else if ($status === OrderStatus::CANCELED) {
            $order->setAsCanceled();
        }

        $this->OrderRepository->update($order);
    }
}
