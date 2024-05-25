<?php

namespace TechChallenge\Application\UseCase\Customer;

use TechChallenge\Domain\Customer\UseCase\ShowByCpf as ICustomerUseCaseShowByCpf;
use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;
use TechChallenge\Domain\Customer\Entities\Customer as CustomerEntity;
use TechChallenge\Domain\Customer\Exceptions\CustomerNotFoundException;
use TechChallenge\Domain\Customer\UseCase\DtoInput;
use TechChallenge\Domain\Customer\ValueObjects\Cpf;

class ShowByCpf implements ICustomerUseCaseShowByCpf
{
    public function __construct(protected readonly ICustomerRepository $CustomerRepository)
    {
    }

    public function execute(DtoInput $data): CustomerEntity
    {
        $cpf = new Cpf($data->cpf);

        if (!$this->CustomerRepository->exist(["cpf" => (string) $cpf]))
            throw new CustomerNotFoundException('Not found', 404);

        return $this->CustomerRepository->show(["cpf" => (string) $cpf]);
    }
}
