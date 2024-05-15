<?php

namespace TechChallenge\Application\UseCase\Customer;

use TechChallenge\Domain\Customer\Factories\Customer as CustomerFactory;
use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;

class Store
{
    private ICustomerRepository $CustomerRepository;

    public function __construct(ICustomerRepository $CustomerRepository)
    {
        $this->CustomerRepository = $CustomerRepository;
    }

    public function execute(Dto $data): string
    {
        $customer = (new CustomerFactory())
            ->new()
            ->withNameCpfEmail($data->name, $data->cpf, $data->email)
            ->build();

        $this->CustomerRepository->store($customer);

        return $customer->getId();
    }
}
