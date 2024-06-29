<?php

namespace TechChallenge\Application\UseCase\Customer;

use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;

final class Index
{
    public function __construct(private readonly ICustomerRepository $CustomerRepository)
    {
    }

    public function execute(array $filters = [], array|bool $append = []): array
    {
        return $this->CustomerRepository->index($filters, $append);
    }
}
