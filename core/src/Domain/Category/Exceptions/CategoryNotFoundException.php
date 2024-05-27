<?php

namespace TechChallenge\Domain\Category\Exceptions;

class CategoryNotFoundException extends CategoryException
{
    public function __construct()
    {
        parent::__construct("Categoria não encontrado", 404);
    }
}
