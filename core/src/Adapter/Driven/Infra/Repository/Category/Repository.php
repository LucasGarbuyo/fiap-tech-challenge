<?php

namespace TechChallenge\Adapter\Driven\Infra\Repository\Category;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use TechChallenge\Domain\Category\Entities\Category as CategoryEntity;
use TechChallenge\Domain\Category\Factories\Category as CategoryFactory;
use TechChallenge\Domain\Category\Exceptions\CategoryNotFoundException;
use TechChallenge\Domain\Category\Repository\ICategory as ICategoryRepository;

class Repository implements ICategoryRepository
{
    /** @return CategoryEntity[] */
    public function index(array $filters = [], array|bool $append = []): array
    {
        $categoriesData = $this->query()->get();

        $categories = [];

        $categoryFactory = new CategoryFactory();

        foreach ($categoriesData as $categoryData)
            $categories[] = $categoryFactory
                ->new($categoryData->id, $categoryData->created_at, $categoryData->updated_at)
                ->withNameType($categoryData->name, $categoryData->type)
                ->build();

        return $categories;
    }

    public function edit(string $id): CategoryEntity
    {
        $categoryData = $this->query()->where('id', $id)->first();

        if (empty($categoryData))
            throw new CategoryNotFoundException();

        return (new CategoryFactory())
            ->new($categoryData->id, $categoryData->created_at, $categoryData->updated_at)
            ->withNameType($categoryData->name, $categoryData->type)
            ->build();
    }

    public function store(CategoryEntity $category): void
    {
        $this->query()
            ->insert(
                [
                    'id' => $category->getId(),
                    'name' => $category->getName(),
                    'type' => $category->getType(),
                    'created_at' => $category->getCreatedAt(),
                    'updated_at' => $category->getUpdatedAt()
                ]
            );
    }

    public function update(CategoryEntity $category): void
    {
        if (!$this->query()->where('id', $category->getId())->exists())
            throw new CategoryNotFoundException();

        $this->query()
            ->where('id', $category->getId())
            ->update(
                [
                    'name' => $category->getName(),
                    'type' => $category->getType(),
                    'updated_at' => $category->getUpdatedAt()
                ]
            );
    }

    public function delete(CategoryEntity $category): void
    {
        $this->query()
            ->where('id', $category->getId())
            ->update(
                [
                    "deleted_at" => $category->getDeletedAt()->format("Y-m-d H:i:s")
                ]
            );
    }

    protected function query(): Builder
    {
        return DB::table("categories")->whereNull('deleted_at');
    }
}
