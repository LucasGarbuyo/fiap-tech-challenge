<?php

namespace TechChallenge\Infra\DB\Eloquent\Category;

use TechChallenge\Domain\Category\DAO\ICategory as ICategoryDAO;

class DAO implements ICategoryDAO
{
    public function index(array $filters = [], array|bool $append = []): array
    {
        return [];
    }

    public function store(array $category): void
    {
    }

    public function show(array $filters = [], array|bool $append = []): ?array
    {
        return null;
    }

    public function update(array $category): void
    {
    }

    public function delete(array $category): void
    {
    }

    public function exist(array $filters = []): bool
    {
        return false;
    }
}
