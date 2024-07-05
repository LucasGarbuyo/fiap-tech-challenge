<?php

namespace TechChallenge\Domain\Category\DAO;

interface ICategory
{
    public function index(array $filters = [], array|bool $append = []): array;

    public function show(array $filters = [], array|bool $append = []): array|null;

    public function store(array $category): void;

    public function update(array $category): void;

    public function delete(array $category): void;

    public function exist(array $filters = []): bool;
}
