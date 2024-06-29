<?php

namespace TechChallenge\Application\UseCase\Order;

use TechChallenge\Domain\Order\Enum\OrderStatus;
use TechChallenge\Domain\Order\Exceptions\InvalidStatusOrder;
use TechChallenge\Domain\Order\Exceptions\OrderException;
use TechChallenge\Domain\Order\Exceptions\OrderNotFoundException;
use TechChallenge\Domain\Order\UseCase\{DtoInput, ChangeStatus as IOrderUseCaseChangeStatus};
use TechChallenge\Domain\Order\Repository\IOrder as IOrderRepository;
use ValueError;

class ChangeStatus implements IOrderUseCaseChangeStatus
{
    public function __construct(protected readonly IOrderRepository $OrderRepository)
    {
    }

    public function execute(DtoInput $data): void
    {
        if (is_null($data->getId()) || !$this->OrderRepository->exist(["id" => $data->getId()]))
            throw new OrderNotFoundException();

        $order = $this->OrderRepository->show(["id" => $data->getId()], true);

        if ($order->isCanceled())
            throw new OrderException("Não pode alterar o status pois o pedido foi cancelado e esse é um status final.", 400);

        if ($order->isNew() || $order->isReceived())
            throw new OrderException("Não pode alterar o status pois o pedido não está pago", 400);

        try {
            $status = OrderStatus::from($data->status);
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
