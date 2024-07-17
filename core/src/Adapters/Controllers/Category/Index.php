<?php

namespace TechChallenge\Adapters\Controllers\Category;

use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Application\UseCase\Category\Index as UseCaseCategoryIndex;
use TechChallenge\Adapters\Presenters\Category\ToArray as PresenterCategoryToArray;

final class Index
{
    public function __construct(private readonly AbstractFactoryRepository $AbstractFactoryRepository)
    {
    }

    public function execute(array $filters = [])
    {
        $results = (new UseCaseCategoryIndex($this->AbstractFactoryRepository))->execute($filters);

        $presenter = new PresenterCategoryToArray();

        if ($this->isPaginated($results))
            $results["data"] = $presenter->executeOnArray($results["data"]);
        else
            $results = $presenter->executeOnArray($results);

        return $results;
    }

    private function isPaginated(array $results): bool
    {
        return isset($results["data"]) && isset($results["pagination"]) && count($results["pagination"]) == 6;
    }
}
