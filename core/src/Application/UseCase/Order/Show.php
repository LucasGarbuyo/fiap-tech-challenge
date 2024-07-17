<?php

namespace TechChallenge\Application\UseCase\Order;

use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Domain\Order\DAO\IOrder as IOrderDAO;
use TechChallenge\Domain\Order\Repository\IOrder as IOrderRepository;
use TechChallenge\Domain\Order\Entities\Order as OrderEntity;
use TechChallenge\Domain\Order\Exceptions\OrderNotFoundException;

final class Show
{
    private readonly IOrderDAO $OrderDAO;

    private readonly IOrderRepository $OrderRepository;

    public function __construct(AbstractFactoryRepository $AbstractFactoryRepository)
    {
        $this->OrderDAO = $AbstractFactoryRepository->getDAO()->createOrderDAO();

        $this->OrderRepository = $AbstractFactoryRepository->createOrderRepository();
    }

    public function execute(?string $id): OrderEntity
    {
        if (!$id || !$this->OrderDAO->exist(["id" => $id]))
            throw new OrderNotFoundException();

        return $this->OrderRepository->show(["id" => $id], true);
    }
}
