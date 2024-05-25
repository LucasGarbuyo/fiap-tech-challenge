<?php

namespace TechChallenge\Application\UseCase\Customer;

use TechChallenge\Domain\Customer\UseCase\DtoInput;
use TechChallenge\Domain\Customer\Entities\Customer;
use TechChallenge\Domain\Customer\UseCase\Show as ICustomerUseCaseShow;

class Show extends ICustomerUseCaseShow
{
    public function execute(DtoInput $data): Customer
    {
        return $this->CustomerRepository->show($data->id);
    }
}
