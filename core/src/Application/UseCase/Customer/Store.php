<?php

namespace TechChallenge\Application\UseCase\Customer;

use TechChallenge\Domain\Customer\DAO\ICustomer as ICustomerDAO;
use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;
use TechChallenge\Domain\Customer\Exceptions\CustomerAlreadyRegistered;
use TechChallenge\Domain\Customer\Factories\Simple as FactorySimpleCustomer;
use TechChallenge\Application\DTO\Customer\DtoInput;
use TechChallenge\Domain\Customer\ValueObjects\Cpf;

final class Store
{
    public function __construct(
        private readonly ICustomerDAO $CustomerDAO,
        private readonly ICustomerRepository $CustomerRepository
    ) {
    }

    public function execute(DtoInput $data): string
    {
        if ($this->CustomerDAO->exist(
            [
                "cpf" => (string) (new Cpf($data->cpf))
            ]
        ))
            throw new CustomerAlreadyRegistered();

        $customer = (new FactorySimpleCustomer())
            ->new()
            ->withNameCpfEmail($data->name, $data->cpf, $data->email)
            ->build();

        $this->CustomerRepository->store($customer);

        return $customer->getId();
    }
}
