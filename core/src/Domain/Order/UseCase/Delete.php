<?php

namespace TechChallenge\Domain\Order\UseCase;

abstract class Delete extends Standard
{
    abstract public function execute(DtoInput $data): void;
}
