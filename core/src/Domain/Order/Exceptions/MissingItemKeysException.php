<?php

namespace TechChallenge\Domain\Order\Exceptions;

use TechChallenge\Domain\Order\Exceptions\OrderException;

class MissingItemKeysException extends OrderException
{
    public function __construct()
    {
        parent::__construct("Cada item deve ter as chaves 'productId' e 'quantity'", 400);
    }
}
