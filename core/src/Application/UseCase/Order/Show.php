<?php

namespace TechChallenge\Application\UseCase\Order;

use TechChallenge\Domain\Order\UseCase\DtoInput;
use TechChallenge\Domain\Order\Entities\Order;
use TechChallenge\Domain\Order\UseCase\Show as IOrderUseCaseShow;

class Show extends IOrderUseCaseShow
{
    public function execute(DtoInput $data): Order
    {
        return $this->OrderRepository->show($data->id);
    }
}
