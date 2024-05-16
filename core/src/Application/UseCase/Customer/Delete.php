<?php

namespace TechChallenge\Application\UseCase\Customer;

use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;

class Delete
{
    private ICustomerRepository $CustomerRepository;

    public function __construct(ICustomerRepository $CustomerRepository)
    {
        $this->CustomerRepository = $CustomerRepository;
    }

    public function execute(Dto $data)
    {
        $customer = $this->CustomerRepository->edit($data->id);

        $customer->delete();

        $this->CustomerRepository->delete($customer);
    }
}
