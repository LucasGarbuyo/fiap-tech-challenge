<?php

namespace TechChallenge\Application\UseCase\Category;

use TechChallenge\Domain\Category\Exceptions\CategoryNotFoundException;
use TechChallenge\Domain\Category\UseCase\Delete as ICategoryUseCaseDelete;
use TechChallenge\Domain\Category\UseCase\DtoInput;
use TechChallenge\Domain\Category\Repository\ICategory as ICategoryRepository;

class Delete implements ICategoryUseCaseDelete
{
    public function __construct(protected readonly ICategoryRepository $CategoryRepository)
    {
    }

    public function execute(DtoInput $data): void
    {
        if (!$this->CategoryRepository->exist(["id" => $data->id]))
            throw new CategoryNotFoundException();

        $category = $this->CategoryRepository->show(["id" => $data->id]);

        $category->delete();

        $this->CategoryRepository->delete($category);
    }
}
