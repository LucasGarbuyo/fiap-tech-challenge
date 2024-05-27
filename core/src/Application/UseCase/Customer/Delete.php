<?php

namespace TechChallenge\Application\UseCase\Customer;

use TechChallenge\Domain\Customer\Exceptions\CustomerNotFoundException;
use TechChallenge\Domain\Customer\UseCase\Delete as ICustomerUseCaseDelete;
use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;
use TechChallenge\Domain\Customer\UseCase\DtoInput;

class Delete implements ICustomerUseCaseDelete
{
    public function __construct(protected readonly ICustomerRepository $CustomerRepository)
    {
    }

    public function execute(DtoInput $data): void
    {
        if (!$this->CustomerRepository->exist(["id" => $data->id]))
            throw new CustomerNotFoundException();

        $customer = $this->CustomerRepository->show(["id" => $data->id]);

        $customer->delete();

        $this->CustomerRepository->delete($customer);
    }
}
