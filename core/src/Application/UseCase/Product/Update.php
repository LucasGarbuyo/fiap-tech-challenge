<?php

namespace TechChallenge\Application\UseCase\Product;

use DateTime;
use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;
use TechChallenge\Domain\Product\Factories\Product as ProductFactory;

class Update
{
    private IProductRepository $ProductRepository;

    public function __construct(IProductRepository $ProductRepository)
    {
        $this->ProductRepository = $ProductRepository;
    }

    public function execute(Dto $data)
    {
        $product = (new ProductFactory())
            ->new($data->id, $data->created_at, $data->updated_at)
            ->withNameDescriptionPrice($data->name, $data->description, $data->price)
            ->build();

        $product->setUpdatedAt(new DateTime());

        return $this->ProductRepository->update($product);
    }
}
