<?php

namespace TechChallenge\Domain\Order\Exceptions;

class OrderNotFoundException extends OrderException
{
    public function __construct()
    {
        parent::__construct("Pedido não encontrado", 404);
    }
}
