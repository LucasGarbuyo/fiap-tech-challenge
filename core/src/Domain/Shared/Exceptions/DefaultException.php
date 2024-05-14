<?php

namespace TechChallenge\Domain\Shared\Exceptions;

use Exception;
use Throwable;

class DefaultException extends Exception
{
    private int $httpStatus;

    public function __construct(string $message = "", int $httpStatus = 400, int $code = 0, ?Throwable $previous = null)
    {
        $this->httpStatus = $httpStatus;

        parent::__construct($message, $code, $previous);
    }

    public function getStatus(): int
    {
        return $this->httpStatus;
    }
}
