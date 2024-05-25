<?php

namespace TechChallenge\Application\UseCase\Customer;

use TechChallenge\Domain\Customer\UseCase\EditByCpf as ICustomerUseCaseEditByCpf;
use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;
use TechChallenge\Domain\Customer\Entities\Customer as CustomerEntity;
use TechChallenge\Domain\Customer\UseCase\DtoInput;
use TechChallenge\Domain\Customer\ValueObjects\Cpf;

class EditByCpf implements ICustomerUseCaseEditByCpf
{
    public function __construct(protected readonly ICustomerRepository $CustomerRepository)
    {
    }

    public function execute(DtoInput $data): CustomerEntity
    {
        $cpf = new Cpf($data->cpf);

        return $this->CustomerRepository->editByCpf($cpf);
    }
}
