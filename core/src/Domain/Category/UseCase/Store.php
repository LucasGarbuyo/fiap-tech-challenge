<?php

namespace TechChallenge\Domain\Category\UseCase;

abstract class Store extends Standard
{
    abstract public function execute(DtoInput $data): string;
}
