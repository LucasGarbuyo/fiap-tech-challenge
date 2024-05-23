<?php

namespace TechChallenge\Application\UseCase\Category;

use TechChallenge\Domain\Category\UseCase\Index as ICategoryUseCaseEdit;

class Index extends ICategoryUseCaseEdit
{
    public function execute(array $filters = [], array|bool $append = []): array
    {
        return $this->CategoryRepository->index($filters, $append);
    }
}
