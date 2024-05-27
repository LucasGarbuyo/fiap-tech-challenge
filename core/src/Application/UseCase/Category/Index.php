<?php

namespace TechChallenge\Application\UseCase\Category;

use TechChallenge\Domain\Category\UseCase\Index as ICategoryUseCaseEdit;
use TechChallenge\Domain\Category\Repository\ICategory as ICategoryRepository;

class Index implements ICategoryUseCaseEdit
{
    public function __construct(protected readonly ICategoryRepository $CategoryRepository)
    {
    }

    public function execute(array $filters = [], array|bool $append = []): array
    {
        return $this->CategoryRepository->index($filters, $append);
    }
}
