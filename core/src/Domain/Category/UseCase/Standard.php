<?php

namespace TechChallenge\Domain\Category\UseCase;

use TechChallenge\Domain\Category\Repository\ICategory as ICategoryRepository;

abstract class Standard
{
    protected ICategoryRepository $CategoryRepository;

    public function __construct(ICategoryRepository $CategoryRepository)
    {
        $this->CategoryRepository = $CategoryRepository;
    }
}
