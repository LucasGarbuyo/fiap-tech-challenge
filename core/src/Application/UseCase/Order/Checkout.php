<?php

namespace TechChallenge\Application\UseCase\Order;

use TechChallenge\Domain\Order\Exceptions\OrderException;
use TechChallenge\Domain\Order\Exceptions\OrderNotFoundException;
use TechChallenge\Domain\Order\UseCase\{DtoInput, Checkout as IOrderUseCaseCheckout};
use TechChallenge\Domain\Order\Repository\IOrder as IOrderRepository;

class Checkout implements IOrderUseCaseCheckout
{
    public function __construct(protected readonly IOrderRepository $OrderRepository)
    {
    }

    public function execute(DtoInput $data): void
    {
        if (is_null($data->getId()) || !$this->OrderRepository->exist(["id" => $data->getId()]))
            throw new OrderNotFoundException();

        $order = $this->OrderRepository->show(["id" => $data->getId()], true);

        if (!$order->isNew())
            throw new OrderException("Não pode ser processado pois o pedido já foi pago", 400);

        $order
            ->setAsReceived()
            ->setAsPaid();

        $this->OrderRepository->update($order);
    }
}
