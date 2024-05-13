<?php

namespace TechChallenge\Application\UseCase\Product;

use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;
use TechChallenge\Domain\Product\Entities\Product;

class Index
{
    private IProductRepository $ProductRepository;

    public function __construct(IProductRepository $ProductRepository)
    {
        $this->ProductRepository = $ProductRepository;
    }

    /** @return Product[] */
    public function execute(array $filters = [], array|bool $append = []): array
    {
        return $this->ProductRepository->index($filters, $append);
    }
}
