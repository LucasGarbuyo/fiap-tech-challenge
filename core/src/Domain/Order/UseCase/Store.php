<?php

namespace TechChallenge\Domain\Order\UseCase;

abstract class Store extends Standard
{
    abstract public function execute(DtoInput $data): string;
}
