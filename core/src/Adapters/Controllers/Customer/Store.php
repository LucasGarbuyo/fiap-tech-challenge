<?php

namespace TechChallenge\Adaptes\Controllers\Customer;

use TechChallenge\Domain\Customer\DAO\ICategory as ICategoryDAO;
use TechChallenge\Application\DTO\Customer\DtoInput as CustomerDTOInput;
use TechChallenge\Adapters\Gateways\Repository\Customer\Repository as CustomerRepository;
use TechChallenge\Application\UseCase\Customer\Store as UseCaseCustomerStore;

final class Store
{
    public function __construct(private readonly ICategoryDAO $CategoryDAO)
    {
    }

    public function execute(CustomerDTOInput $dto): string
    {
        return (new UseCaseCustomerStore($this->CategoryDAO, (new CustomerRepository($this->CategoryDAO))))->execute($dto);
    }
}
