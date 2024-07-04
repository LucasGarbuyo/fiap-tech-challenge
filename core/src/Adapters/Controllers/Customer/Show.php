<?php

namespace TechChallenge\Adapters\Controllers\Customer;

use TechChallenge\Domain\Customer\DAO\ICustomer as ICustomerDAO;
use TechChallenge\Adapters\Gateways\Repository\Customer\Repository as CustomerRepository;
use TechChallenge\Application\UseCase\Customer\Show as UseCaseCustomerShow;
use TechChallenge\Adapters\Presenters\Customer\ToArray as PresenterCustomerToArray;

final class Show
{
    public function __construct(private readonly ICustomerDAO $CustomerDAO)
    {
    }

    public function execute(string $id): array
    {
        $category = (new UseCaseCustomerShow($this->CustomerDAO, (new CustomerRepository($this->CustomerDAO))))->execute($id);

        return (new PresenterCustomerToArray())->execute($category);
    }
}
