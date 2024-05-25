<?php

namespace TechChallenge\Domain\Customer\UseCase;

use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;
use TechChallenge\Domain\Customer\Entities\Customer as CustomerEntity;

interface Show
{
    public function __construct(ICustomerRepository $CustomerRepository);

    public function execute(DtoInput $data): CustomerEntity;
}
