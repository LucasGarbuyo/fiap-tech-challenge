<?php

namespace TechChallenge\Adapters\Controllers\Order;

use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Application\UseCase\Order\Webhook as UseCaseOrderWebhook;

final class Webhook
{
    public function __construct(private readonly AbstractFactoryRepository $AbstractFactoryRepository)
    {
    }

    public function execute(?string $id)
    {
        (new UseCaseOrderWebhook($this->AbstractFactoryRepository))->execute($id);
    }
}
