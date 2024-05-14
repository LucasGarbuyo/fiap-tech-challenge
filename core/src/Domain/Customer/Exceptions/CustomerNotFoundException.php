<?php

namespace TechChallenge\Domain\Customer\Exceptions;

class CustomerNotFoundException extends CustomerException
{
    public function __construct()
    {
        parent::__construct("Cliente não encontrado", 404);
    }
}
