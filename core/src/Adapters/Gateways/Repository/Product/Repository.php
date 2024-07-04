<?php

namespace TechChallenge\Adapters\Gateways\Repository\Product;

use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;
use TechChallenge\Domain\Product\DAO\IProduct as IProductDAO;
use TechChallenge\Infra\DB\Eloquent\Product\Model as ProductModel;
use TechChallenge\Domain\Shared\ValueObjects\Price;

use TechChallenge\Domain\Product\Entities\Product as ProductEntity;
use TechChallenge\Adapters\Presenters\Product\ToArray as ProductToArray;


final class Repository implements IProductRepository
{
    public function __construct(private readonly IProductDAO $ProductDAO)
    {
    }

    public function index(array $filters = [], array|bool $append = []): array
    {

        $products = ProductModel::all();
       
        $productsArray = $products->map(function ($product) {
            $productEntity = new ProductEntity(
                id: $product->id,
                created_at: new \DateTime($product->created_at),
                updated_at: new \DateTime($product->updated_at)
            );
            $productEntity->setName($product->name)
                          ->setDescription($product->description)
                          ->setImage($product->image)
                          ->setPrice(new Price($product->price));

            $productArray = $productEntity->toArray();
            array_walk_recursive($productArray, function (&$item) {
                if (is_string($item)) {
                    $item = mb_convert_encoding($item, 'UTF-8', 'auto');
                }
            });

            return $productArray;
        })->toArray();

        return $productsArray;
    }

    /*public function store(CustomerEntity $customer): void
    {
        $array = (new CustomerToArray())->execute($customer);

        $this->CustomerDAO->store($array);
    }

    public function show(array $filters = [], array|bool $append = []): ?CustomerEntity
    {
        return null;
    }

    public function update(CustomerEntity $customer): void
    {
    }

    public function delete(CustomerEntity $customer): void
    {
    }*/
}
