<?php

namespace TechChallenge\Adapter\Driven\Infra\Repository\Category;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use TechChallenge\Domain\Category\Entities\Category as CategoryEntity;
use TechChallenge\Domain\Category\Factories\Category as CategoryFactory;
use TechChallenge\Domain\Category\Repository\ICategory as ICategoryRepository;

class Repository implements ICategoryRepository
{
    /** @return CategoryEntity[] */
    public function index(array $filters = [], array|bool $append = []): array
    {
        $categoriesData = $this->filters($this->query($append), $filters)->get();

        $categories = [];

        $categoryFactory = new CategoryFactory();

        foreach ($categoriesData as $categoryData) {
            $categories[] = $categoryFactory
                ->new($categoryData->id, $categoryData->created_at, $categoryData->updated_at)
                ->withNameType($categoryData->name, $categoryData->type)
                ->build();
        }

        return $categories;
    }

    public function show(array $filters = [], array|bool $append = []): CategoryEntity|null
    {
        $categoryData = $this->filters($this->query($append), $filters)->first();

        if (empty($categoryData))
            return null;

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
        $this->filters($this->query(), ["id" => $category->getId()])
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
        $this->filters($this->query(), ["id" => $category->getId()])
            ->update(
                [
                    "deleted_at" => $category->getDeletedAt()->format("Y-m-d H:i:s")
                ]
            );
    }

    public function exist(array $filters = []): bool
    {
        return $this->filters($this->query(), $filters)->exists();
    }

    public function filters(Builder $query, array $filters = []): Builder
    {
        if (!empty($filters["id"])) {
            if (!is_array($filters["id"]))
                $filters["id"] = [$filters["id"]];

            $query->whereIn('id', $filters["id"]);
        }

        return $query;
    }

    public function query(array|bool $append = []): Builder
    {
        return DB::table("categories")->whereNull('deleted_at');
    }
}
