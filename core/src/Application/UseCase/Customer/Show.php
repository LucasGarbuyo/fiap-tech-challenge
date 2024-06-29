<?php

namespace TechChallenge\Application\UseCase\Customer;

use TechChallenge\Domain\Customer\UseCase\Show as ICustomerUseCaseShow;
use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;
use TechChallenge\Domain\Customer\UseCase\DtoInput;
use TechChallenge\Domain\Customer\Entities\Customer;
use TechChallenge\Domain\Customer\Exceptions\CustomerNotFoundException;

class Show implements ICustomerUseCaseShow
{
    public function __construct(protected readonly ICustomerRepository $CustomerRepository)
    {
    }

    public function execute(DtoInput $data): Customer
    {
        if (!$this->CustomerRepository->exist(["id" => $data->id]))
            throw new CustomerNotFoundException();

        return $this->CustomerRepository->show(["id" => $data->id]);
    }
}
