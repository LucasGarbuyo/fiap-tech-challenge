<?php

namespace TechChallenge\Adapters\Gateways\Repository\Eloquent\Product;

use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;
use TechChallenge\Domain\Product\DAO\IProduct as IProductDAO;
use TechChallenge\Domain\Product\SimpleFactory\Product as ProductFactory;
use TechChallenge\Domain\Product\Entities\Product as ProductEntity;
use TechChallenge\Adapters\Presenters\Product\ToArray as ProductToArray;


final class Repository implements IProductRepository
{
    private readonly ProductFactory $ProductFactory;

    private readonly ProductToArray $ProductToArray;

    public function __construct(private readonly IProductDAO $ProductDAO)
    {
        $this->ProductFactory = new ProductFactory();
        $this->ProductToArray = new ProductToArray();
    }

    public function index(array $filters = [], array|bool $append = []): array
    {
        $results = $this->ProductDAO->index($filters, $append);

        if ($this->isPaginated($results))
            $results["data"] = $this->toProductEntities($results["data"]);
        else
            $results = $this->toProductEntities($results);

        return $results;
    }

    public function show(array $filters = [], array|bool $append = []): ?ProductEntity
    {
        $customer = $this->ProductDAO->show($filters, $append);

        if (is_null($customer))
            return null;

        return $this->toProductEntitie($customer);
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

    private function isPaginated(array $results): bool
    {
        return isset($results["data"]) && isset($results["pagination"]) && count($results["pagination"]) == 6;
    }

    private function toProductEntities(array $products): array
    {
        $productEntities = [];

        foreach ($products as $product)
            $productEntities[] = $this->toProductEntitie($product);

        return $productEntities;
    }

    private function toProductEntitie(array $product): ProductEntity
    {
        return $this->ProductFactory
            ->new($product["id"], $product["created_at"], $product["updated_at"])
            ->withCategoryId($product["category_id"])
            ->withNameDescriptionPriceImage($product["name"], $product["description"], $product["price"], $product["image"])
            ->build();
    }
}
