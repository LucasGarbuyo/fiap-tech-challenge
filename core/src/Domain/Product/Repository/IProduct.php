<?php

namespace TechChallenge\Domain\Product\Repository;

use TechChallenge\Domain\Product\Entities\Product;

interface IProduct
{
    /** @return Product[] */
    public function index(array $filters = [], array|bool $append = []): array;

    public function show(string $id): Product;

    public function store(Product $product): void;

    public function update(Product $product): void;

    public function delete(Product $product): void;
}
