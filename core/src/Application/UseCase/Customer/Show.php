<?php

namespace TechChallenge\Application\UseCase\Customer;

use TechChallenge\Domain\Customer\UseCase\Show as ICustomerUseCaseShow;
use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;
use TechChallenge\Domain\Customer\UseCase\DtoInput;
use TechChallenge\Domain\Customer\Entities\Customer;

class Show implements ICustomerUseCaseShow
{
    public function __construct(protected readonly ICustomerRepository $CustomerRepository)
    {
    }

    public function execute(DtoInput $data): Customer
    {
        return $this->CustomerRepository->show($data->id);
    }
}
