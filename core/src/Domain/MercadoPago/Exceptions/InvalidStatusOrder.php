<?php

namespace TechChallenge\Domain\Order\Exceptions;

class InvalidStatusOrder extends OrderException
{
    public function __construct()
    {
        parent::__construct("Status inválida", 400);
    }
}
