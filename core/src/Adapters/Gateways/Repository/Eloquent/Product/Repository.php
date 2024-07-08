<?php

namespace TechChallenge\Adapters\Gateways\Repository\Eloquent\Product;

use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;
use TechChallenge\Domain\Product\DAO\IProduct as IProductDAO;
use TechChallenge\Domain\Product\SimpleFactory\Product as SimpleFactoryProduct;
use TechChallenge\Domain\Product\Entities\Product as ProductEntity;
use TechChallenge\Domain\Category\Entities\Category as CategoryEntity;
use TechChallenge\Adapters\Presenters\Product\ToArray as ProductToArray;
use TechChallenge\Adapters\Gateways\Repository\Eloquent\Abstract\Repository as AbstractRepository;
use TechChallenge\Domain\Category\SimpleFactory\Category as SimpleFactoryCategory;

final class Repository extends AbstractRepository implements IProductRepository
{
    private readonly ProductToArray $ProductToArray;

    private readonly SimpleFactoryProduct $SimpleFactoryProduct;

    private readonly SimpleFactoryCategory $SimpleFactoryCategory;

    public function __construct(private readonly IProductDAO $ProductDAO)
    {
        $this->ProductToArray = new ProductToArray();

        $this->SimpleFactoryProduct = new SimpleFactoryProduct();

        $this->SimpleFactoryCategory = new SimpleFactoryCategory();
    }

    public function index(array $filters = [], array|bool $append = []): array
    {
        $results = $this->ProductDAO->index($filters, $append);

        if ($this->isPaginated($results))
            $results["data"] = $this->toEntities($results["data"]);
        else
            $results = $this->toEntities($results);

        return $results;
    }

    public function show(array $filters = [], array|bool $append = []): ?ProductEntity
    {
        $product = $this->ProductDAO->show($filters, $append);

        if (is_null($product))
            return null;

        return $this->toEntity($product);
    }

    public function store(ProductEntity $product): void
    {
        $this->ProductDAO->store($this->ProductToArray->execute($product));
    }

    public function update(ProductEntity $product): void
    {
        $this->ProductDAO->update($this->ProductToArray->execute($product));
    }

    public function delete(ProductEntity $product): void
    {
        $this->ProductDAO->delete($this->ProductToArray->execute($product));
    }

    protected function toEntity(array $product): ProductEntity
    {
        $this->SimpleFactoryProduct
            ->new($product["id"], $product["created_at"], $product["updated_at"])
            ->withCategoryId($product["category_id"])
            ->withNameDescriptionPriceImage($product["name"], $product["description"], $product["price"], $product["image"]);

        if (isset($product["category"]) && isset($product["category"]["id"])) {
            $category = $this->createCategoryEntity($product["category"]);

            $this->SimpleFactoryProduct->withCategory($category);
        }

        return $this->SimpleFactoryProduct->build();
    }

    protected function createCategoryEntity(array $category): ?CategoryEntity
    {
        return $this->SimpleFactoryCategory
            ->restore($category["id"], $category["created_at"], $category["updated_at"])
            ->withNameType($category["name"], $category["type"])
            ->build();
    }
}
