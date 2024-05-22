<?php

namespace TechChallenge\Domain\Customer\UseCase;

abstract class Delete extends Standard
{
    abstract public function execute(DtoInput $data): void;
}
