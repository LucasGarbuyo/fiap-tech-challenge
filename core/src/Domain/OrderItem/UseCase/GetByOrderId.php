<?php

namespace TechChallenge\Domain\OrderItem\UseCase;

use TechChallenge\Domain\Order\UseCase\DtoInput;
use Illuminate\Support\Collection;

abstract class GetByOrderId extends Standard
{
    abstract public function execute(DtoInput $data): Collection;
}
