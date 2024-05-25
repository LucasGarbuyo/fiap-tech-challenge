<?php

namespace TechChallenge\Application\UseCase\Customer;

use TechChallenge\Domain\Customer\Factories\Customer as CustomerFactory;
use TechChallenge\Domain\Customer\UseCase\DtoInput;
use TechChallenge\Domain\Customer\UseCase\Store as ICustomerUseCaseStore;
use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;

class Store implements ICustomerUseCaseStore
{
    public function __construct(protected readonly ICustomerRepository $CustomerRepository)
    {
    }

    public function execute(DtoInput $data): string
    {
        $customer = (new CustomerFactory())
            ->new()
            ->withNameCpfEmail($data->name, $data->cpf, $data->email)
            ->build();

        $this->CustomerRepository->store($customer);

        return $customer->getId();
    }
}
