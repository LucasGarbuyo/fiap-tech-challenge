<?php

namespace TechChallenge\Application\UseCase\Product;

use TechChallenge\Domain\Category\Exceptions\CategoryNotFoundException;
use TechChallenge\Domain\Category\DAO\ICategory as ICategoryDAO;
use TechChallenge\Domain\Product\DAO\IProduct as IProductDAO;
use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Domain\Product\SimpleFactory\Product as FactorySimpleProduct;
use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;
use TechChallenge\Application\DTO\Product\DtoInput;
use TechChallenge\Domain\Product\Exceptions\ProductNotFoundException;
use DateTime;

final class Update
{
    private readonly IProductRepository $ProductRepository;

    private readonly IProductDAO $ProductDAO;

    private readonly ICategoryDAO $CategoryDAO;

    public function __construct(AbstractFactoryRepository $AbstractFactoryRepository)
    {
        $this->ProductDAO = $AbstractFactoryRepository->getDAO()->createProductDAO();

        $this->ProductRepository = $AbstractFactoryRepository->createProductRepository();

        $this->CategoryDAO = $AbstractFactoryRepository->getDAO()->createCategoryDAO();
    }

    public function execute(DtoInput $data): void
    {
        if (!$this->ProductDAO->exist(["id" => $data->id]))
            throw new ProductNotFoundException();

        $productFactory = (new FactorySimpleProduct())
            ->new($data->id, $data->createdAt, $data->updatedAt)
            ->withNameDescriptionPriceImage($data->name, $data->description, $data->price, $data->image);

        if (!empty($data->categoryId)) {
            if (!$this->CategoryDAO->exist(["id" => $data->categoryId]))
                throw new CategoryNotFoundException();
            $productFactory->withCategoryId($data->categoryId);
        }

        $product = $productFactory->build();

        $product->setUpdatedAt(new DateTime());

        $this->ProductRepository->update($product);
    }
}
