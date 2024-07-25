<?php

namespace TechChallenge\Domain\Order\Exceptions;

class InvalidItemOrder extends OrderException
{
    public function __construct()
    {
        parent::__construct("Item inválido", 400);
    }
}
