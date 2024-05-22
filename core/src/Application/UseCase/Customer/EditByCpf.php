<?php

namespace TechChallenge\Application\UseCase\Customer;

use TechChallenge\Domain\Customer\Entities\Customer as CustomerEntity;
use TechChallenge\Domain\Customer\UseCase\DtoInput;
use TechChallenge\Domain\Customer\ValueObjects\Cpf;
use TechChallenge\Domain\Customer\UseCase\EditByCpf as ICustomerUseCaseEditByCpf;

class EditByCpf extends ICustomerUseCaseEditByCpf
{
    public function execute(DtoInput $data): CustomerEntity
    {
        $cpf = new Cpf($data->cpf);

        return $this->CustomerRepository->editByCpf($cpf);
    }
}
