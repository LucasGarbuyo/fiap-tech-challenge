<?php

namespace TechChallenge\Application\UseCase\Customer;

use TechChallenge\Domain\Customer\UseCase\DtoInput;
use TechChallenge\Domain\Customer\Entities\Customer;
use TechChallenge\Domain\Customer\UseCase\Edit as ICustomerUseCaseEdit;

class Edit extends ICustomerUseCaseEdit
{
    public function execute(DtoInput $data): Customer
    {
        return $this->CustomerRepository->edit($data->id);
    }
}
