<?php

namespace TechChallenge\Adapter\Driven\Infra\Repository\Product;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use TechChallenge\Domain\Category\Factories\Category as CategoryFactory;
use TechChallenge\Domain\Product\Entities\Product as ProductEntity;
use TechChallenge\Domain\Product\Factories\Product as ProductFactory;
use TechChallenge\Domain\Product\Exceptions\ProductNotFoundException;
use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;

class Repository implements IProductRepository
{
    /** @return ProductEntity[] */
    public function index(array $filters = [], array|bool $append = []): array
    {
        $productsData = $this->query()->get();

        $products = [];

        $ProductFactory = new ProductFactory();

        foreach ($productsData as $productData) {
            $ProductFactory
                ->new($productData->id, $productData->created_at, $productData->updated_at)
                ->withCategoryIdNameDescriptionPrice($productData->category_id, $productData->name, $productData->description, $productData->price);

            if (!empty($productData->category_id)) {
                $categoryData = $this->queryCategory()->where('id', $productData->category_id)->first();

                if (!empty($categoryData)) {
                    $category = (new CategoryFactory())
                        ->new()
                        ->withNameType($categoryData->name, $categoryData->type)
                        ->build();

                    $ProductFactory->withCategory($category);
                }
            }

            $products[] = $ProductFactory->build();
        }

        return $products;
    }

    public function show(string $id): ProductEntity
    {
        $productData = $this->query()->where('id', $id)->first();

        if (empty($productData))
            throw new ProductNotFoundException('Not found', 404);

        $categoryData = $this->queryCategory()->where('id', $productData->category_id)->first();

        $category = (new CategoryFactory())
            ->new()
            ->withNameType($categoryData->name, $categoryData->type)
            ->build();

        return (new ProductFactory())
            ->new($productData->id, $productData->created_at, $productData->updated_at)
            ->withCategoryNameDescriptionPrice($category, $productData->name, $productData->description, $productData->price)
            ->build();
    }

    public function store(ProductEntity $product): void
    {
        $this->query()
            ->insert(
                [
                    'id' => $product->getId(),
                    'category_id' => $product->getCategoryId(),
                    'name' => $product->getName(),
                    'description' => $product->getDescription(),
                    'price' =>  $product->getPrice()->getValue(),
                    'created_at' => $product->getCreatedAt(),
                    'updated_at' => $product->getUpdatedAt()
                ]
            );
    }

    public function update(ProductEntity $product): void
    {
        if (!$this->query()->where('id', $product->getId())->exists())
            throw new ProductNotFoundException('Not found', 404);

        $this->query()
            ->where('id', $product->getId())
            ->update(
                [
                    'category_id' => $product->getCategoryId(),
                    'name' => $product->getName(),
                    'description' => $product->getDescription(),
                    'price' => $product->getPrice()->getValue(),
                    'updated_at' => $product->getUpdatedAt()
                ]
            );
    }

    public function delete(ProductEntity $product): void
    {
        $this->query()
            ->where('id', $product->getId())
            ->update(
                [
                    "deleted_at" => $product->getDeletedAt()->format("Y-m-d H:i:s")
                ]
            );
    }

    protected function query(): Builder
    {
        return DB::table("products")->whereNull('deleted_at');
    }

    protected function queryCategory(): Builder
    {
        return DB::table("categories")->whereNull('deleted_at');
    }
}
