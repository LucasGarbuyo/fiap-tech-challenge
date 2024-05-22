<?php

namespace TechChallenge\Application\UseCase\Customer;

use TechChallenge\Domain\Customer\UseCase\Delete as ICustomerUseCaseDelete;
use TechChallenge\Domain\Customer\UseCase\DtoInput;

class Delete extends ICustomerUseCaseDelete
{
    public function execute(DtoInput $data): void
    {
        $customer = $this->CustomerRepository->edit($data->id);

        $customer->delete();

        $this->CustomerRepository->delete($customer);
    }
}
