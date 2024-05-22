<?php

namespace TechChallenge\Domain\Product\UseCase;

abstract class Store extends Standard
{
    abstract public function execute(DtoInput $data): string;
}
