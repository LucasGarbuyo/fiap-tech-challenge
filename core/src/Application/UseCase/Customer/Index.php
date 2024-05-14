<?php

namespace TechChallenge\Application\UseCase\Customer;

use TechChallenge\Domain\Customer\Entities\Customer;
use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;

class Index
{
    private ICustomerRepository $CustomerRepository;

    public function __construct(ICustomerRepository $CustomerRepository)
    {
        $this->CustomerRepository = $CustomerRepository;
    }

    /** @return Customer[] */
    public function execute(array $filters = [], array|bool $append = []): array
    {
        return $this->CustomerRepository->index($filters, $append);
    }
}
