<?php

namespace TechChallenge\Application\UseCase\Customer;

use TechChallenge\Domain\Customer\UseCase\DtoInput as ICustomerUseCaseDtoInput;

class DtoInput implements ICustomerUseCaseDtoInput
{
    public $id;
    public $name;
    public $cpf;
    public $email;
    public $created_at;
    public $updated_at;

    public function __construct($id = null, $name = null, $cpf = null, $email = null, $created_at = null, $updated_at = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->cpf = $cpf;
        $this->email = $email;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
}
