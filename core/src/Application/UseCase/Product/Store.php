<?php

namespace TechChallenge\Application\UseCase\Product;

use TechChallenge\Domain\Category\Exceptions\CategoryNotFoundException;
use TechChallenge\Domain\Product\Factories\Product as ProductFactory;
use TechChallenge\Domain\Product\UseCase\DtoInput;
use TechChallenge\Domain\Product\UseCase\Store as IProductUseCaseStore;
use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;
use TechChallenge\Domain\Category\Repository\ICategory as ICategoryRepository;

class Store implements IProductUseCaseStore
{
    public function __construct(
        protected readonly IProductRepository $ProductRepository,
        protected readonly ICategoryRepository $CategoryRepository
    ) {
    }

    public function execute(DtoInput $data): string
    {
        $productFactory = (new ProductFactory())
            ->new()
            ->withNameDescriptionPrice($data->name, $data->description, $data->price);

        if (!empty($data->category_id)) {
            if (!$this->CategoryRepository->exist(["id" => $data->category_id]))
                throw new CategoryNotFoundException();

            $productFactory->withCategoryId($data->category_id);
        }

        $product = $productFactory->build();

        $this->ProductRepository->store($product);

        return $product->getId();
    }
}
