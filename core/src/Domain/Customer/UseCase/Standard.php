<?php

namespace TechChallenge\Domain\Customer\UseCase;

use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;

abstract class Standard
{
    protected ICustomerRepository $CustomerRepository;

    public function __construct(ICustomerRepository $CustomerRepository)
    {
        $this->CustomerRepository = $CustomerRepository;
    }
}
