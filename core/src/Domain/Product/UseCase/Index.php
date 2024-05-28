<?php

namespace TechChallenge\Domain\Product\UseCase;

use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;

interface Index
{
    public function __construct(IProductRepository $ProductRepository);

    public function execute(array $filters = [], array|bool $append = []): array;
}
