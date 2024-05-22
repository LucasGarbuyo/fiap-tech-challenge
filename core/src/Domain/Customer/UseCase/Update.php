<?php

namespace TechChallenge\Domain\Customer\UseCase;

abstract class Update extends Standard
{
    abstract public function execute(DtoInput $data): void;
}
