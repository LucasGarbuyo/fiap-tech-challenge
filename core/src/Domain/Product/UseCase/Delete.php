<?php

namespace TechChallenge\Domain\Product\UseCase;

abstract class Delete extends Standard
{
    abstract public function execute(DtoInput $data): void;
}
