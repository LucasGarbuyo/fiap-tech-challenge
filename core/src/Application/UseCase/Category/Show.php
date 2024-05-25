<?php

namespace TechChallenge\Application\UseCase\Category;

use TechChallenge\Domain\Category\UseCase\DtoInput;
use TechChallenge\Domain\Category\Entities\Category;
use TechChallenge\Domain\Category\UseCase\Show as ICategoryUseCaseShow;

class Show extends ICategoryUseCaseShow
{
    public function execute(DtoInput $data): Category
    {
        return $this->CategoryRepository->show($data->id);
    }
}
