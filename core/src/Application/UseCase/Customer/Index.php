<?php

namespace TechChallenge\Application\UseCase\Customer;

use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;

final class Index
{
    private readonly ICustomerRepository $CustomerRepository;

    public function __construct(AbstractFactoryRepository $AbstractFactoryRepository)
    {
        $this->CustomerRepository = $AbstractFactoryRepository->createCustomerRepository();
    }

    public function execute(array $filters = [], array|bool $append = []): array
    {
        return $this->CustomerRepository->index($filters, $append);
    }
}
