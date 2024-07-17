<?php

namespace TechChallenge\Adapters\Controllers\Order;

use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Application\UseCase\Order\Checkout as UseCaseOrderCheckout;

final class Checkout
{
    public function __construct(private readonly AbstractFactoryRepository $AbstractFactoryRepository)
    {
    }

    public function execute(?string $id)
    {
        return (new UseCaseOrderCheckout($this->AbstractFactoryRepository))->execute($id);
    }
}
