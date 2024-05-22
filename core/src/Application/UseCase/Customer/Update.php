<?php

namespace TechChallenge\Application\UseCase\Customer;

use DateTime;
use TechChallenge\Domain\Customer\Factories\Customer as CustomerFactory;
use TechChallenge\Domain\Customer\UseCase\DtoInput;
use TechChallenge\Domain\Customer\UseCase\Update as ICustomerUseCaseUpdate;

class Update extends ICustomerUseCaseUpdate
{
    public function execute(DtoInput $data): void
    {
        $customer = (new CustomerFactory())
            ->new($data->id, $data->created_at, $data->updated_at)
            ->withNameCpfEmail($data->name, $data->cpf, $data->email)
            ->build();

        $customer->setUpdatedAt(new DateTime());

        $this->CustomerRepository->update($customer);
    }
}
