<?php

namespace TechChallenge\Adapter\Driven\Infra\Repository\Product;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
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

        foreach ($productsData as $productData)
            $products[] = $ProductFactory
                ->new($productData->id, $productData->created_at, $productData->updated_at)
                ->withNameDescriptionPrice($productData->name, $productData->description, $productData->price)
                ->build();

        return $products;
    }

    public function edit(string $id): ProductEntity
    {
        $productData = $this->query()->where('id', $id)->first();

        if (empty($productData))
            throw new ProductNotFoundException();

        return (new ProductFactory())
            ->new($productData->id, $productData->created_at, $productData->updated_at)
            ->withNameDescriptionPrice($productData->name, $productData->description, $productData->price)
            ->build();
    }

    public function store(ProductEntity $product): void
    {
        $this->query()
            ->insert(
                [
                    'id' => $product->getId(),
                    'name' => $product->getName(),
                    'description' => $product->getDescription(),
                    'price' => $product->getPrice(),
                    'created_at' => $product->getCreatedAt(),
                    'updated_at' => $product->getUpdatedAt()
                ]
            );
    }

    public function update(ProductEntity $product): void
    {
        if (!$this->query()->where('id', $product->getId())->exists())
            throw new ProductNotFoundException();

        $this->query()
            ->where('id', $product->getId())
            ->update(
                [
                    'name' => $product->getName(),
                    'description' => $product->getDescription(),
                    'price' => $product->getPrice(),
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
}
