<?php

namespace TechChallenge\Application\UseCase\Customer;

use DateTime;
use TechChallenge\Domain\Customer\Exceptions\CustomerNotFoundException;
use TechChallenge\Domain\Customer\Factories\Customer as CustomerFactory;
use TechChallenge\Domain\Customer\UseCase\DtoInput;
use TechChallenge\Domain\Customer\UseCase\Update as ICustomerUseCaseUpdate;
use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;

class Update implements ICustomerUseCaseUpdate
{
    public function __construct(protected readonly ICustomerRepository $CustomerRepository)
    {
    }

    public function execute(DtoInput $data): void
    {
        if (!$this->CustomerRepository->exist(["id" => $data->id]))
            throw new CustomerNotFoundException();

        $customer = (new CustomerFactory())
            ->new($data->id, $data->created_at, $data->updated_at)
            ->withNameCpfEmail($data->name, $data->cpf, $data->email)
            ->build();

        $customer->setUpdatedAt(new DateTime());

        $this->CustomerRepository->update($customer);
    }
}
