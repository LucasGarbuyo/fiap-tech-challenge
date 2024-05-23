<?php

namespace TechChallenge\Application\UseCase\Category;

use TechChallenge\Domain\Category\UseCase\Delete as ICategoryUseCaseDelete;
use TechChallenge\Domain\Category\UseCase\DtoInput;

class Delete extends ICategoryUseCaseDelete
{
    public function execute(DtoInput $data): void
    {
        $category = $this->CategoryRepository->edit($data->id);

        $category->delete();

        $this->CategoryRepository->delete($category);
    }
}
