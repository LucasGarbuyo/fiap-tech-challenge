<?php

namespace TechChallenge\Application\UseCase\Category;

use TechChallenge\Domain\Category\Factories\Category as CategoryFactory;
use TechChallenge\Domain\Category\UseCase\DtoInput;
use TechChallenge\Domain\Category\UseCase\Store as ICategoryUseCaseStore;
use TechChallenge\Domain\Category\Repository\ICategory as ICategoryRepository;

class Store implements ICategoryUseCaseStore
{
    public function __construct(protected readonly ICategoryRepository $CategoryRepository)
    {
    }

    public function execute(DtoInput $data): string
    {
        $category = (new CategoryFactory())
            ->new()
            ->withNameType($data->name, $data->type)
            ->build();

        $this->CategoryRepository->store($category);

        return $category->getId();
    }
}
