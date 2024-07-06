<?php

namespace TechChallenge\Adapters\Controllers\Order;

use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Application\UseCase\Order\Show as UseCaseOrderShow;
use TechChallenge\Adapters\Presenters\Order\ToArray as PresenterOrderToArray;

final class Show
{
    public function __construct(private readonly AbstractFactoryRepository $AbstractFactoryRepository)
    {
    }

    public function execute(string $id)
    {
        $customer = (new UseCaseOrderShow($this->AbstractFactoryRepository))->execute($id);

        return (new PresenterOrderToArray())->execute($customer);
    }
}
