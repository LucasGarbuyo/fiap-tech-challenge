<?php

namespace TechChallenge\Application\UseCase\Customer;

use DateTime;
use TechChallenge\Domain\Customer\Exceptions\CustomerAlreadyRegistered;
use TechChallenge\Domain\Customer\Exceptions\CustomerNotFoundException;
use TechChallenge\Domain\Customer\Factories\Customer as CustomerFactory;
use TechChallenge\Domain\Customer\UseCase\DtoInput;
use TechChallenge\Domain\Customer\UseCase\Update as ICustomerUseCaseUpdate;
use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;
use TechChallenge\Domain\Customer\ValueObjects\Cpf;

class Update implements ICustomerUseCaseUpdate
{
    public function __construct(protected readonly ICustomerRepository $CustomerRepository)
    {
    }

    public function execute(DtoInput $data): void
    {
        if (!$this->CustomerRepository->exist(["id" => $data->id]))
            throw new CustomerNotFoundException();

        $cpf = new Cpf($data->cpf);

        if ($this->CustomerRepository->exist(
            [
                "not-id" => $data->id,
                "cpf" => (string) $cpf
            ]
        ))
            throw new CustomerAlreadyRegistered();

        $customer = (new CustomerFactory())
            ->new($data->id, $data->created_at, $data->updated_at)
            ->withNameCpfEmail($data->name, $data->cpf, $data->email)
            ->build();

        $customer->setUpdatedAt(new DateTime());

        $this->CustomerRepository->update($customer);
    }
}
