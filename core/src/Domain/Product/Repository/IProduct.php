<?php

namespace TechChallenge\Domain\Product\Repository;

use TechChallenge\Domain\Product\Entities\Product;
use TechChallenge\Domain\Category\Repository\ICategory as ICategoryRepository;

interface IProduct
{
    public function __construct(ICategoryRepository $CategoryRepository);

    /** @return Product[] */
    public function index(array $filters = [], array|bool $append = []): array;

    public function show(array $filters = [], array|bool $append = []): Product|null;

    public function store(Product $product): void;

    public function update(Product $product): void;

    public function delete(Product $product): void;

}
