<?php

namespace TechChallenge\Domain\Customer\Exceptions;

class CustomerAlreadyRegistered extends CustomerException
{
    public function __construct()
    {
        parent::__construct("Já existe um cliente cadastrado com esse CPF", 400);
    }
}
