<?php

namespace TechChallenge\Application\UseCase\Category;

use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Domain\Category\Repository\ICategory as ICategoryRepository;

final class Index
{
    private readonly ICategoryRepository $CategoryRepository;

    public function __construct(AbstractFactoryRepository $AbstractFactoryRepository)
    {
        $this->CategoryRepository = $AbstractFactoryRepository->createCategoryRepository();
    }

    public function execute(array $filters = [], array|bool $append = []): array
    {
        return $this->CategoryRepository->index($filters, $append);
    }
}
