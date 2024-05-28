<?php

namespace TechChallenge\Application\UseCase\Product;

use TechChallenge\Domain\Product\UseCase\Index as IProductUseCaseIndex;
use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;


class Index implements IProductUseCaseIndex
{
    public function __construct(protected readonly IProductRepository $ProductRepository)
    {
    }

    public function execute(array $filters = [], array|bool $append = []): array
    {
        return $this->ProductRepository->index($filters, $append);
    }
}
