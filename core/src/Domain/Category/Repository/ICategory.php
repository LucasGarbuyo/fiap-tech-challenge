<?php

namespace TechChallenge\Domain\Category\Repository;

use TechChallenge\Domain\Category\Entities\Category as CategoryEntity;

interface ICategory
{
    public function index(array $filters = [], array|bool $append = []): array;

    public function show(array $filters = [], array|bool $append = []): CategoryEntity|null;

    public function store(CategoryEntity $category): void;

    public function update(CategoryEntity $category): void;

    public function delete(CategoryEntity $category): void;
}
