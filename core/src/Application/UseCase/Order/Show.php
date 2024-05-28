<?php

namespace TechChallenge\Application\UseCase\Order;

use TechChallenge\Domain\Order\UseCase\DtoInput;
use TechChallenge\Domain\Order\Entities\Order;
use TechChallenge\Domain\Order\Exceptions\OrderNotFoundException;
use TechChallenge\Domain\Order\UseCase\Show as IOrderUseCaseShow;
use TechChallenge\Domain\Order\Repository\IOrder as IOrderRepository;

class Show implements IOrderUseCaseShow
{
    public function __construct(protected readonly IOrderRepository $OrderRepository)
    {
    }

    public function execute(DtoInput $data, bool|array $append = []): Order
    {
        if (!$this->OrderRepository->exist(["id" => $data->getId()]))
            throw new OrderNotFoundException();

        return $this->OrderRepository->show(["id" => $data->getId()], $append);
    }
}
