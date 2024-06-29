<?php

namespace TechChallenge\Application\UseCase\Customer;

use TechChallenge\Domain\Customer\DAO\ICategory as ICustomerDAO;
use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;
use TechChallenge\Domain\Customer\Entities\Customer as CustomerEntity;
use TechChallenge\Domain\Customer\Exceptions\CustomerNotFoundException;
use TechChallenge\Domain\Customer\ValueObjects\Cpf;

final class ShowByCpf
{
    public function __construct(
        private readonly ICustomerDAO $CustomerDAO,
        private readonly ICustomerRepository $CustomerRepository
    ) {
    }

    public function execute(Cpf $cpf): CustomerEntity
    {
        if (!$this->CustomerDAO->exist(["cpf" => (string) $cpf]))
            throw new CustomerNotFoundException();

        return $this->CustomerRepository->show(["cpf" => (string) $cpf], true);
    }
}
