<?php

namespace TechChallenge\Domain\Product\Repository;

use TechChallenge\Domain\Product\Entities\Product;
use TechChallenge\Domain\Product\DAO\IProduct as IProductDAO;

interface IProduct
{
    public function __construct(IProductDAO $IProductDAO);

    public function index(array $filters = [], array|bool $append = []): array;

    public function show(array $filters = [], array|bool $append = []): Product|null;

    public function store(Product $product): void;

    public function update(Product $product): void;

    public function delete(Product $product): void;
}
