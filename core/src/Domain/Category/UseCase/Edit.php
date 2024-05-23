<?php

namespace TechChallenge\Domain\Category\UseCase;

use TechChallenge\Domain\Category\Entities\Category as CategoryEntity;

abstract class Edit extends Standard
{
    abstract public function execute(DtoInput $data): CategoryEntity;
}
