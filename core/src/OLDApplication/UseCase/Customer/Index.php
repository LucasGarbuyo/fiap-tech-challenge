<?php

namespace TechChallenge\Application\UseCase\Customer;

use TechChallenge\Domain\Customer\UseCase\Index as ICustomerUseCaseEdit;
use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;

class Index implements ICustomerUseCaseEdit
{
    public function __construct(protected readonly ICustomerRepository $CustomerRepository)
    {
    }

    public function execute(array $filters = [], array|bool $append = []): array
    {
        return $this->CustomerRepository->index($filters, $append);
    }
}
