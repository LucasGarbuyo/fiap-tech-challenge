<?php

namespace TechChallenge\Domain\Customer\UseCase;

use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;

interface Delete
{
    public function __construct(ICustomerRepository $CustomerRepository);

    public function execute(DtoInput $data): void;
}
