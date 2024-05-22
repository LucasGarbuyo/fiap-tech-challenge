<?php

namespace TechChallenge\Application\UseCase\Product;

use DateTime;
use TechChallenge\Domain\Product\Factories\Product as ProductFactory;
use TechChallenge\Domain\Product\UseCase\DtoInput;
use TechChallenge\Domain\Product\UseCase\Update as IProductUseCaseUpdate;

class Update extends IProductUseCaseUpdate
{
    public function execute(DtoInput $data): void
    {
        $product = (new ProductFactory())
            ->new($data->id, $data->created_at, $data->updated_at)
            ->withNameDescriptionPrice($data->name, $data->description, $data->price)
            ->build();

        $product->setUpdatedAt(new DateTime());

        $this->ProductRepository->update($product);
    }
}
