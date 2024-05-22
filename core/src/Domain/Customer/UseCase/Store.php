<?php

namespace TechChallenge\Domain\Customer\UseCase;

abstract class Store extends Standard
{
    abstract public function execute(DtoInput $data): string;
}
