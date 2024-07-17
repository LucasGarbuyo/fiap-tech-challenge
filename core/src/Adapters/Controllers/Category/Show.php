<?php

namespace TechChallenge\Adapters\Controllers\Category;

use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Application\UseCase\Category\Show as UseCaseCategoryShow;
use TechChallenge\Adapters\Presenters\Category\ToArray as PresenterCategoryToArray;

final class Show
{
    public function __construct(private readonly AbstractFactoryRepository $AbstractFactoryRepository)
    {
    }

    public function execute(string $id)
    {
        $category = (new UseCaseCategoryShow($this->AbstractFactoryRepository))->execute($id);

        return (new PresenterCategoryToArray())->execute($category);
    }
}
