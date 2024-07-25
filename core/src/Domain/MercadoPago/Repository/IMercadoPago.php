<?php

namespace TechChallenge\Domain\MercadoPago\Repository;

use TechChallenge\Domain\Order\Entities\Order as OrderEntity;
use TechChallenge\Domain\Order\DAO\IOrder as IOrderDAO;

interface IMercadoPago
{
    public function __construct(IOrderDAO $OrderDAO);

    public function createPayment(OrderEntity $order): void;
}
