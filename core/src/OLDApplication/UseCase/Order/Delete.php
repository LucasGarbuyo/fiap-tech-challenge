<?php

namespace TechChallenge\Application\UseCase\Order;

use TechChallenge\Domain\Order\Exceptions\OrderException;
use TechChallenge\Domain\Order\Exceptions\OrderNotFoundException;
use TechChallenge\Domain\Order\UseCase\Delete as IOrderUseCaseDelete;
use TechChallenge\Domain\Order\UseCase\DtoInput;
use TechChallenge\Domain\Order\Repository\IOrder as IOrderRepository;

class Delete implements IOrderUseCaseDelete
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
            throw new OrderException("Não pode excluir um pedido que não seja novo", 400);

        $order->delete();

        $this->OrderRepository->delete($order);
    }
}
