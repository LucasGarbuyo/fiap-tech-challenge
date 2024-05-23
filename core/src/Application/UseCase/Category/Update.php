<?php

namespace TechChallenge\Application\UseCase\Category;

use DateTime;
use TechChallenge\Domain\Category\Factories\Category as CategoryFactory;
use TechChallenge\Domain\Category\UseCase\DtoInput;
use TechChallenge\Domain\Category\UseCase\Update as ICategoryUseCaseUpdate;

class Update extends ICategoryUseCaseUpdate
{
    public function execute(DtoInput $data): void
    {
        $category = (new CategoryFactory())
            ->new($data->id, $data->created_at, $data->updated_at)
            ->withNameType($data->name, $data->type)
            ->build();

        $category->setUpdatedAt(new DateTime());

        $this->CategoryRepository->update($category);
    }
}
