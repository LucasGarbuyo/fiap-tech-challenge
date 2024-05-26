<?php

namespace TechChallenge\Domain\OrderItem\UseCase;

use TechChallenge\Domain\Order\UseCase\DtoInput;
use TechChallenge\Domain\Order\Entities\Item as OrderItemEntity;

abstract class Show extends Standard
{
    abstract public function execute(DtoInput $data): OrderItemEntity;
}
