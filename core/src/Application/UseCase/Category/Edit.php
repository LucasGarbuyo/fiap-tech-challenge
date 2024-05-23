<?php

namespace TechChallenge\Application\UseCase\Category;

use TechChallenge\Domain\Category\UseCase\DtoInput;
use TechChallenge\Domain\Category\Entities\Category;
use TechChallenge\Domain\Category\UseCase\Edit as ICategoryUseCaseEdit;

class Edit extends ICategoryUseCaseEdit
{
    public function execute(DtoInput $data): Category
    {
        return $this->CategoryRepository->edit($data->id);
    }
}
