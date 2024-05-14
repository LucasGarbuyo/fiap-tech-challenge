<?php

namespace TechChallenge\Application\UseCase\Customer;

use TechChallenge\Domain\Customer\Entities\Customer;
use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;
use TechChallenge\Domain\Customer\ValueObjects\Cpf;
use TechChallenge\Domain\Customer\ValueObjects\Email;

class Store
{
    private ICustomerRepository $CustomerRepository;

    public function __construct(ICustomerRepository $CustomerRepository)
    {
        $this->CustomerRepository = $CustomerRepository;
    }

    public function execute(Dto $data): string
    {
        $customer = new Customer(
            uniqid("CUST_", true),
            $data->name,
            new Cpf($data->cpf),
            new Email($data->email)
        );

        return $this->CustomerRepository->store($customer);
    }
}
