<?php

namespace TechChallenge\Domain\Category\UseCase;

use TechChallenge\Domain\Category\Repository\ICategory as ICategoryRepository;

interface Index
{
    public function __construct(ICategoryRepository $CategoryRepository);

    public function execute(array $filters = [], array|bool $append = []): array;
}
