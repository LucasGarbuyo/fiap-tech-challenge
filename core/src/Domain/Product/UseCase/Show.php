<?php

namespace TechChallenge\Domain\Product\UseCase;

use TechChallenge\Domain\Product\Entities\Product as ProductEntity;

abstract class Show extends Standard
{
    abstract public function execute(DtoInput $data): ProductEntity;
}
