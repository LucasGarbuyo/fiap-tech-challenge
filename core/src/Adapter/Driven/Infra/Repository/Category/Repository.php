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
        $CategorysData = $this->query()->get();

        $Categorys = [];

        $CategoryFactory = new CategoryFactory();

        foreach ($CategorysData as $CategoryData)
            $Categorys[] = $CategoryFactory
                ->new($CategoryData->id, $CategoryData->created_at, $CategoryData->updated_at)
                ->withNameType($CategoryData->name, $CategoryData->type)
                ->build();

        return $Categorys;
    }

    public function edit(string $id): CategoryEntity
    {
        $CategoryData = $this->query()->where('id', $id)->first();

        if (empty($CategoryData))
            throw new CategoryNotFoundException();

        return (new CategoryFactory())
            ->new($CategoryData->id, $CategoryData->created_at, $CategoryData->updated_at)
            ->withNameType($CategoryData->name, $CategoryData->type)
            ->build();
    }

    public function store(CategoryEntity $Category): void
    {
        $this->query()
            ->insert(
                [
                    'id' => $Category->getId(),
                    'name' => $Category->getName(),
                    'type' => $Category->getType(),
                    'created_at' => $Category->getCreatedAt(),
                    'updated_at' => $Category->getUpdatedAt()
                ]
            );
    }

    public function update(CategoryEntity $Category): void
    {
        if (!$this->query()->where('id', $Category->getId())->exists())
            throw new CategoryNotFoundException();

        $this->query()
            ->where('id', $Category->getId())
            ->update(
                [
                    'name' => $Category->getName(),
                    'type' => $Category->getType(),
                    'updated_at' => $Category->getUpdatedAt()
                ]
            );
    }

    public function delete(CategoryEntity $Category): void
    {
        $this->query()
            ->where('id', $Category->getId())
            ->update(
                [
                    "deleted_at" => $Category->getDeletedAt()->format("Y-m-d H:i:s")
                ]
            );
    }

    protected function query(): Builder
    {
        return DB::table("Categories")->whereNull('deleted_at');
    }
}
