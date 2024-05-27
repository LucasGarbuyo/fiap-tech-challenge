<?php

namespace TechChallenge\Domain\Category\UseCase;

use TechChallenge\Domain\Category\Repository\ICategory as ICategoryRepository;

interface Delete
{
    public function __construct(ICategoryRepository $CategoryRepository);

    public function execute(DtoInput $data): void;
}
