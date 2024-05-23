<?php

namespace TechChallenge\Domain\Category\UseCase;

abstract class Update extends Standard
{
    abstract public function execute(DtoInput $data): void;
}
