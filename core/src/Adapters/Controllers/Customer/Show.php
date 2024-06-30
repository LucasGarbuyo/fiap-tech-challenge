<?php

namespace TechChallenge\Adaptes\Controllers\Customer;

use TechChallenge\Domain\Customer\DAO\ICategory as ICategoryDAO;
use TechChallenge\Adapters\Gateways\Repository\Customer\Repository as CustomerRepository;
use TechChallenge\Application\UseCase\Customer\Show as UseCaseCustomerShow;
use TechChallenge\Adapters\Presenters\Customer\ToJson as PresenterCustomerToJson;

final class Show
{
    public function __construct(private readonly ICategoryDAO $CategoryDAO)
    {
    }

    public function execute(string $id): string
    {
        $category = (new UseCaseCustomerShow($this->CategoryDAO, (new CustomerRepository($this->CategoryDAO))))->execute($id);

        return (new PresenterCustomerToJson())->execute($category);
    }
}
