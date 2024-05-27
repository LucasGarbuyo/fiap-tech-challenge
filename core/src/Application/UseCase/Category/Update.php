<?php

namespace TechChallenge\Application\UseCase\Category;

use DateTime;
use TechChallenge\Domain\Category\Exceptions\CategoryNotFoundException;
use TechChallenge\Domain\Category\Factories\Category as CategoryFactory;
use TechChallenge\Domain\Category\UseCase\DtoInput;
use TechChallenge\Domain\Category\UseCase\Update as ICategoryUseCaseUpdate;
use TechChallenge\Domain\Category\Repository\ICategory as ICategoryRepository;

class Update implements ICategoryUseCaseUpdate
{
    public function __construct(protected readonly ICategoryRepository $CategoryRepository)
    {
    }

    public function execute(DtoInput $data): void
    {
        if (!$this->CategoryRepository->exist(["id" => $data->id]))
            throw new CategoryNotFoundException();

        $category = (new CategoryFactory())
            ->new($data->id, $data->created_at, $data->updated_at)
            ->withNameType($data->name, $data->type)
            ->build();

        $category->setUpdatedAt(new DateTime());

        $this->CategoryRepository->update($category);
    }
}
