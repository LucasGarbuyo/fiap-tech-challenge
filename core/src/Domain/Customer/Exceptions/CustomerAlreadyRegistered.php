<?php

namespace TechChallenge\Domain\Customer\Exceptions;

class CustomerAlreadyRegistered extends CustomerException
{
    public function __construct()
    {
        parent::__construct("Cliente já cadastrado", 400);
    }
}
