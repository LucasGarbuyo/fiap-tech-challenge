<?php

namespace TechChallenge\Domain\Customer\UseCase;

use TechChallenge\Domain\Customer\Entities\Customer as CustomerEntity;

abstract class Edit extends Standard
{
    abstract public function execute(DtoInput $data): CustomerEntity;
}
