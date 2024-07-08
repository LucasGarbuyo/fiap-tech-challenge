<?php

namespace TechChallenge\Application\UseCase\Product;

use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;

final class Index
{
    private IProductRepository $ProductRepository;

    public function __construct(AbstractFactoryRepository $AbstractFactoryRepository)
    {
        $this->ProductRepository = $AbstractFactoryRepository->createProductRepository();
    }

    public function execute(array $filters = [], array|bool $append = []): array
    {
        return $this->ProductRepository->index($filters, $append);
    }
}
