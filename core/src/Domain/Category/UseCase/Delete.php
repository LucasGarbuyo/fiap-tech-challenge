<?php

namespace TechChallenge\Domain\Category\UseCase;

abstract class Delete extends Standard
{
    abstract public function execute(DtoInput $data): void;
}
