<?php

namespace TechChallenge\Domain\Customer\UseCase;

use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;

interface Index
{
    public function __construct(ICustomerRepository $CustomerRepository);

    public function execute(array $filters = [], array|bool $append = []): array;
}
