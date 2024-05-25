<?php

namespace TechChallenge\Domain\Order\UseCase;

use TechChallenge\Domain\Order\Entities\Order as OrderEntity;

abstract class Show extends Standard
{
    abstract public function execute(DtoInput $data): OrderEntity;
}
