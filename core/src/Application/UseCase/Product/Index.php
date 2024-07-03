<?php

namespace TechChallenge\Application\UseCase\Product;

use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;

final class Index
{
    public function __construct(private readonly IProductRepository $ProductRepository)
    {
    }

    public function execute(array $filters = [], array|bool $append = []): array
    {
        return $this->ProductRepository->index($filters, $append);
    }
}
