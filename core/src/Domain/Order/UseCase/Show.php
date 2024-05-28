<?php

namespace TechChallenge\Domain\Order\UseCase;

use TechChallenge\Domain\Order\Repository\IOrder as IOrderRepository;
use TechChallenge\Domain\Order\Entities\Order as OrderEntity;

interface Show
{
    public function __construct(IOrderRepository $OrderRepository);

    public function execute(DtoInput $data): OrderEntity;
}
