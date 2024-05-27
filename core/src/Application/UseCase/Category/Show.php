<?php

namespace TechChallenge\Application\UseCase\Category;

use TechChallenge\Domain\Category\UseCase\DtoInput;
use TechChallenge\Domain\Category\Entities\Category;
use TechChallenge\Domain\Category\Exceptions\CategoryNotFoundException;
use TechChallenge\Domain\Category\UseCase\Show as ICategoryUseCaseShow;
use TechChallenge\Domain\Category\Repository\ICategory as ICategoryRepository;

class Show implements ICategoryUseCaseShow
{
    public function __construct(protected readonly ICategoryRepository $CategoryRepository)
    {
    }

    public function execute(DtoInput $data): Category
    {
        if (!$this->CategoryRepository->exist(["id" => $data->id]))
            throw new CategoryNotFoundException('Not found', 404);

        return $this->CategoryRepository->show(["id" => $data->id]);
    }
}
