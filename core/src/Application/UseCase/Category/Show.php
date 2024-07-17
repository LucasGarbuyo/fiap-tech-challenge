<?php

namespace TechChallenge\Application\UseCase\Category;

use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Domain\Category\Repository\ICategory as ICategoryRepository;
use TechChallenge\Domain\Category\DAO\ICategory as ICategoryDAO;
use TechChallenge\Domain\Category\Exceptions\CategoryNotFoundException;
use TechChallenge\Domain\Category\Entities\Category;

final class Show
{
    private readonly ICategoryRepository $CategoryRepository;

    private readonly ICategoryDAO $CategoryDAO;

    public function __construct(AbstractFactoryRepository $AbstractFactoryRepository)
    {
        $this->CategoryRepository = $AbstractFactoryRepository->createCategoryRepository();

        $this->CategoryDAO = $AbstractFactoryRepository->getDAO()->createCategoryDAO();
    }

    public function execute(string $id): Category
    {
        if (!$this->CategoryDAO->exist(["id" => $id]))
            throw new CategoryNotFoundException();

        return $this->CategoryRepository->show(["id" => $id], true);
    }
}
