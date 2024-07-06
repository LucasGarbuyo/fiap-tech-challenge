<?php

namespace TechChallenge\Application\UseCase\Category;

use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Domain\Category\Repository\ICategory as ICategoryRepository;
use TechChallenge\Domain\Category\DAO\ICategory as ICategoryDAO;
use TechChallenge\Domain\Category\Exceptions\CategoryNotFoundException;
use TechChallenge\Domain\Category\SimpleFactory\Category as SimpleFactoryCategory;
use TechChallenge\Application\DTO\Category\DtoInput;
use DateTime;

final class Update
{
    private readonly ICategoryRepository $CategoryRepository;

    private readonly ICategoryDAO $CategoryDAO;

    public function __construct(AbstractFactoryRepository $AbstractFactoryRepository)
    {
        $this->CategoryRepository = $AbstractFactoryRepository->createCategoryRepository();

        $this->CategoryDAO = $AbstractFactoryRepository->getDAO()->createCategoryDAO();
    }

    public function execute(DtoInput $dto): void
    {
        if (!$this->CategoryDAO->exist(["id" => $dto->id]))
            throw new CategoryNotFoundException();

        $category = (new SimpleFactoryCategory())
            ->new($dto->id, $dto->createdAt, $dto->updatedAt)
            ->withNameType($dto->name, $dto->type)
            ->build();

        $category->setUpdatedAt(new DateTime());

        $this->CategoryRepository->update($category);
    }
}
