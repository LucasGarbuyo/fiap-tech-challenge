<?php

namespace TechChallenge\Application\UseCase\Customer;

use TechChallenge\Domain\Customer\DAO\ICategory as ICustomerDAO;
use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;
use TechChallenge\Domain\Customer\Exceptions\CustomerAlreadyRegistered;
use TechChallenge\Domain\Customer\Exceptions\CustomerNotFoundException;
use TechChallenge\Domain\Customer\Factories\Simple as FactorySimpleCustomer;
use TechChallenge\Application\DTO\Customer\DtoInput;
use TechChallenge\Domain\Customer\ValueObjects\Cpf;
use DateTime;

final class Update
{
    public function __construct(
        private readonly ICustomerDAO $CustomerDAO,
        private readonly ICustomerRepository $CustomerRepository
    ) {
    }

    public function execute(DtoInput $data): void
    {
        if (!$this->CustomerDAO->exist(["id" => $data->id]))
            throw new CustomerNotFoundException();

        $cpf = new Cpf($data->cpf);

        if ($this->CustomerDAO->exist(
            [
                "not-id" => $data->id,
                "cpf" => (string) $cpf
            ]
        ))
            throw new CustomerAlreadyRegistered();

        $customer = (new FactorySimpleCustomer())
            ->new($data->id, $data->createdAt, $data->updatedAt)
            ->withNameCpfEmail($data->name, $data->cpf, $data->email)
            ->build();

        $customer->setUpdatedAt(new DateTime());

        $this->CustomerRepository->update($customer);
    }
}
