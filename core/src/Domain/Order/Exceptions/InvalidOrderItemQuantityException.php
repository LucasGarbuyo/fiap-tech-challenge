<?php

namespace TechChallenge\Domain\Order\Exceptions;

use TechChallenge\Domain\Order\Exceptions\OrderException;

class InvalidOrderItemQuantityException extends OrderException
{
    public function __construct()
    {
        parent::__construct("Quantidade de itens inválida", 400);
    }
}
