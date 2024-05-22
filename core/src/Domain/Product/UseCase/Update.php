<?php

namespace TechChallenge\Domain\Product\UseCase;

abstract class Update extends Standard
{
    abstract public function execute(DtoInput $data): void;
}
