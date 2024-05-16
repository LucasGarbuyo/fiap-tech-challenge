<?php

namespace TechChallenge\Application\UseCase\Customer;

use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;
use TechChallenge\Domain\Customer\Entities\Customer as CustomerEntity;

class Edit
{
    private ICustomerRepository $CustomerRepository;

    public function __construct(ICustomerRepository $CustomerRepository)
    {
        $this->CustomerRepository = $CustomerRepository;
    }

    public function execute(Dto $data): CustomerEntity
    {
        return $this->CustomerRepository->edit($data->id);
    }
}
