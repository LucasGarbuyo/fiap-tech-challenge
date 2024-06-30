<?php

namespace TechChallenge\Adaptes\Controllers\Customer;

use TechChallenge\Domain\Customer\DAO\ICategory as ICategoryDAO;
use TechChallenge\Application\DTO\Customer\DtoInput as CustomerDTOInput;
use TechChallenge\Adapters\Gateways\Repository\Customer\Repository as CustomerRepository;
use TechChallenge\Application\UseCase\Customer\Update as UseCaseCustomerUpdate;

final class Update
{
    public function __construct(private readonly ICategoryDAO $CategoryDAO)
    {
    }

    public function execute(CustomerDTOInput $dto): void
    {
        return (new UseCaseCustomerUpdate($this->CategoryDAO, (new CustomerRepository($this->CategoryDAO))))->execute($dto);
    }
}
