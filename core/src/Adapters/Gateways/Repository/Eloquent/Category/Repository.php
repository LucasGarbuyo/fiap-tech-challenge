<?php

namespace TechChallenge\Adapters\Gateways\Repository\Eloquent\Category;

use TechChallenge\Domain\Category\Repository\ICategory as ICategoryRepository;
use TechChallenge\Domain\Category\SimpleFactory\Category as SimpleFactoryCategory;
use TechChallenge\Adapters\Presenters\Category\ToArray as CategoryToArray;
use TechChallenge\Domain\Category\DAO\ICategory as ICategoryDAO;
use TechChallenge\Domain\Category\Entities\Category as CategoryEntity;
use TechChallenge\Adapters\Gateways\Repository\Eloquent\Abstract\Repository as AbstractRepository;

final class Repository extends AbstractRepository implements ICategoryRepository
{
    private readonly SimpleFactoryCategory $SimpleFactoryCategory;

    private readonly CategoryToArray $CategoryToArray;

    public function __construct(private readonly ICategoryDAO $CategoryDAO)
    {
        $this->SimpleFactoryCategory = new SimpleFactoryCategory();

        $this->CategoryToArray = new CategoryToArray();
    }

    public function index(array $filters = [], array|bool $append = []): array
    {
        $results = $this->CategoryDAO->index($filters, $append);

        if ($this->isPaginated($results))
            $results["data"] = $this->toEntities($results["data"]);
        else
            $results = $this->toEntities($results);       

        return $results;
    }

    public function store(CategoryEntity $category): void
    {
        $this->CategoryDAO->store($this->CategoryToArray->execute($category));
    }

    public function show(array $filters = [], array|bool $append = []): ?CategoryEntity
    {
        $category = $this->CategoryDAO->show($filters, $append);

        if (is_null($category))
            return null;

        return $this->toEntity($category);
    }

    public function update(CategoryEntity $category): void
    {
        $this->CategoryDAO->update($this->CategoryToArray->execute($category));
    }

    public function delete(CategoryEntity $category): void
    {
        $this->CategoryDAO->delete($this->CategoryToArray->execute($category));
    }

    protected function toEntity(array $category): CategoryEntity
    {
        return $this->SimpleFactoryCategory
            ->new($category["id"], $category["created_at"], $category["updated_at"])
            ->withNameType($category["name"], $category["type"])
            ->build();
    }
}
