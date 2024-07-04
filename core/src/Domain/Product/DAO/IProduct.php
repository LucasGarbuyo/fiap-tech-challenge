<?php

namespace TechChallenge\Domain\Product\DAO;

interface IProduct
{
    public function index(array $filters = [], array|bool $append = []): array;

    // public function edit(array $filters = [], array|bool $append = []): array|null;

    // public function create(array $category): void;

    // public function update(array $category): void;

    // public function delete(array $category): void;

}
