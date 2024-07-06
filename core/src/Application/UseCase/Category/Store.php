<?php

namespace TechChallenge\Application\UseCase\Category;

use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Domain\Category\Repository\ICategory as ICategoryRepository;
use TechChallenge\Domain\Category\SimpleFactory\Category as SimpleFactoryCategory;
use TechChallenge\Application\DTO\Category\DtoInput;

final class Store
{
    private readonly ICategoryRepository $CategoryRepository;

    public function __construct(AbstractFactoryRepository $AbstractFactoryRepository)
    {
        $this->CategoryRepository = $AbstractFactoryRepository->createCategoryRepository();
    }

    public function execute(DtoInput $dto): string
    {
        $category = (new SimpleFactoryCategory())
            ->new()
            ->withNameType($dto->name, $dto->type)
            ->build();

        $this->CategoryRepository->store($category);

        return $category->getId();
    }
}
