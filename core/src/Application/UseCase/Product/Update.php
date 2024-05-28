<?php

namespace TechChallenge\Application\UseCase\Product;

use DateTime;
use TechChallenge\Domain\Category\Exceptions\CategoryNotFoundException;
use TechChallenge\Domain\Product\Factories\Product as ProductFactory;
use TechChallenge\Domain\Product\UseCase\DtoInput;
use TechChallenge\Domain\Product\UseCase\Update as IProductUseCaseUpdate;
use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;
use TechChallenge\Domain\Category\Repository\ICategory as ICategoryRepository;
use TechChallenge\Domain\Product\Exceptions\ProductNotFoundException;

class Update implements IProductUseCaseUpdate
{
    public function __construct(
        protected readonly IProductRepository $ProductRepository,
        protected readonly ICategoryRepository $CategoryRepository
    ) {
    }

    public function execute(DtoInput $data): void
    {
        if (!$this->ProductRepository->exist(["id" => $data->id]))
            throw new ProductNotFoundException();

        $productFactory = (new ProductFactory())
            ->new()
            ->withNameDescriptionPrice($data->name, $data->description, $data->price);

        if (!empty($data->category_id)) {
            if (!$this->CategoryRepository->exist(["id" => $data->category_id]))
                throw new CategoryNotFoundException();

            $productFactory->withCategoryId($data->category_id);
        }

        $product = $productFactory->build();

        $product->setUpdatedAt(new DateTime());

        $this->ProductRepository->update($product);
    }
}
