<?php

namespace TechChallenge\Domain\Category\UseCase;

use TechChallenge\Domain\Category\Repository\ICategory as ICategoryRepository;
use TechChallenge\Domain\Category\Entities\Category as CategoryEntity;

interface Show
{
    public function __construct(ICategoryRepository $CategoryRepository);

    public function execute(DtoInput $data): CategoryEntity;
}
