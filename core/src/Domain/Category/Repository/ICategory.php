<?php

namespace TechChallenge\Domain\Category\Repository;

use TechChallenge\Domain\Category\Entities\Category;

interface ICategory
{
    /** @return Category[] */
    public function index(array $filters = [], array|bool $append = []): array;

    public function show(array $filters = [], array|bool $append = []): Category;

    public function store(Category $Category): void;

    public function update(Category $Category): void;

    public function delete(Category $Category): void;

    public function exist(array $filters = []): bool;
}
