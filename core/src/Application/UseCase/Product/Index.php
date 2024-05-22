<?php

namespace TechChallenge\Application\UseCase\Product;

use TechChallenge\Domain\Product\UseCase\Index as IProductUseCaseIndex;

class Index extends IProductUseCaseIndex
{
    public function execute(array $filters = [], array|bool $append = []): array
    {
        return $this->ProductRepository->index($filters, $append);
    }
}
