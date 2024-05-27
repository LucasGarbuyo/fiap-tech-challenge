<?php

namespace TechChallenge\Domain\Category\UseCase;

use TechChallenge\Domain\Category\Repository\ICategory as ICategoryRepository;

interface Update
{
    public function __construct(ICategoryRepository $CategoryRepository);

    public function execute(DtoInput $data): void;
}
