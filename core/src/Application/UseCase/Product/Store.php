<?php

namespace TechChallenge\Application\UseCase\Product;

use TechChallenge\Domain\Product\Factories\Product as ProductFactory;
use TechChallenge\Domain\Product\UseCase\DtoInput;
use TechChallenge\Domain\Product\UseCase\Store as IProductUseCaseStore;

class Store extends IProductUseCaseStore
{
    public function execute(DtoInput $data): string
    {
        $product = (new ProductFactory())
            ->new()
            ->withNameDescriptionPrice($data->name, $data->description, $data->price)
            ->build();

        $this->ProductRepository->store($product);

        return $product->getId();
    }
}
