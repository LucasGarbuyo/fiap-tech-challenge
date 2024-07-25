<?php

namespace TechChallenge\Domain\Order\Exceptions;

use TechChallenge\Domain\Order\Exceptions\OrderException;

class InvalidItemQuantityException extends OrderException
{
    public function __construct()
    {
        parent::__construct("Quantidade do item inválida", 400);
    }
}
