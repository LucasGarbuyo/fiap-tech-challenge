<?php

namespace TechChallenge\Domain\Category\Exceptions;

use TechChallenge\Domain\Shared\Exceptions\DefaultException;

class CategoryNotFoundException extends DefaultException
{
    public function __construct()
    {
        parent::__construct("Categoria não encontrado", 404);
    }
}
