<?php

namespace TechChallenge\Adapter\Driven\Infra\Repository\Product;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use TechChallenge\Domain\Product\Entities\Product as ProductEntity;
use TechChallenge\Domain\Product\Factories\Product as ProductFactory;
use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;
use TechChallenge\Domain\Category\Repository\ICategory as ICategoryRepository;

class Repository implements IProductRepository
{
    public function __construct(protected readonly ICategoryRepository $CategoryRepository)
    {
    }

    /** @return ProductEntity[] */
    public function index(array $filters = [], array|bool $append = []): array
    {
        $productsData = $this->filters($this->query($append), $filters)->get();

        if (count($productsData) == 0)
            return [];

        $products = [];

        $productFactory = new ProductFactory();

        foreach ($productsData as $productData) {
            $productFactory
                ->new($productData->id, $productData->created_at, $productData->updated_at)
                ->withNameDescriptionPrice(
                    $productData->name,
                    $productData->description,
                    $productData->price,
                    $productData->image
                );

            if (($append === true || in_array("category", $append)) && !empty($productData->category_id)) {

                $category = $this->CategoryRepository->show(["id" => $productData->category_id]);

                if (!empty($category))
                    $productFactory->withCategoryIdCategory($productData->category_id, $category);
            }

            $products[] = $productFactory->build();
        }

        return $products;
    }

    public function show(array $filters = [], array|bool $append = []): ProductEntity|null
    {
        $productData = $this->filters($this->query($append), $filters)->first();

        if (empty($productData))
            return null;

        $productFactory = (new ProductFactory())
            ->new($productData->id, $productData->created_at, $productData->updated_at)
            ->withNameDescriptionPrice($productData->name, $productData->description, $productData->price, $productData->image);

        if (($append === true || in_array("category", $append)) && !empty($productData->category_id)) {

            $category = $this->CategoryRepository->show(["id" => $productData->category_id]);

            if (!empty($category))
                $productFactory->withCategoryIdCategory($productData->category_id, $category);
        }

        return $productFactory->build();
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
                    'image' => $product->getImage(),
                    'created_at' => $product->getCreatedAt(),
                    'updated_at' => $product->getUpdatedAt()
                ]
            );
    }

    public function update(ProductEntity $product): void
    {
        $this->filters($this->query(), ["id" => $product->getId()])
            ->update(
                [
                    'category_id' => $product->getCategoryId(),
                    'name' => $product->getName(),
                    'description' => $product->getDescription(),
                    'price' => $product->getPrice()->getValue(),
                    'image' => $product->getImage(),
                    'updated_at' => $product->getUpdatedAt()
                ]
            );
    }

    public function delete(ProductEntity $product): void
    {
        $this->filters($this->query(), ["id" => $product->getId()])
            ->update(
                [
                    "deleted_at" => $product->getDeletedAt()->format("Y-m-d H:i:s")
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
        return DB::table("products")->whereNull('deleted_at');
    }
}
