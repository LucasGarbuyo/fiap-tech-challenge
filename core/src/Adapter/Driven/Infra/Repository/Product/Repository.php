<?php

namespace TechChallenge\Adapter\Driven\Infra\Repository\Product;

use DateTime;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use TechChallenge\Domain\Product\Entities\Product;
use TechChallenge\Domain\Product\Exceptions\ProductNotFoundException;
use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;

class Repository implements IProductRepository
{
    /** @return Product[] */
    public function index(array $filters = [], array|bool $append = []): array
    {
        $productsData = $this->query()->get();

        $products = [];

        foreach ($productsData as $productData)
            $products[] = (new Product((array) $productData));

        return $products;
    }

    public function edit(string $id): Product
    {
        $productData = $this->query()->where('id', $id)->first();

        if (empty($productData))
            throw new ProductNotFoundException();

        return (new Product((array) $productData));
    }

    public function store(Product $product): void
    {
        $this->query()->insert(
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

    public function update(Product $product): void
    {
        if (!$this->query()->where('id', $product->getId())->exists())
            throw new ProductNotFoundException();

        $this->query()->where('id', $product->getId())->update(
            [
                'name' => $product->getName(),
                'description' => $product->getDescription(),
                'price' => $product->getPrice(),
                'updated_at' => $product->getUpdatedAt()
            ]
        );
    }

    public function delete(string $id, DateTime $deleteAt): void
    {
        if (!$this->query()->where('id', $id)->exists())
            throw new ProductNotFoundException();

        $this->query()->where('id', $id)->update(
            [
                "deleted_at" => $deleteAt->format('Y-m-d H:i:s')
            ]
        );
    }

    protected function query(): Builder
    {
        return DB::table("products")->whereNull('deleted_at');
    }
}
