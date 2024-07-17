<?php

namespace TechChallenge\Application\UseCase\Product;

use TechChallenge\Domain\Category\Exceptions\CategoryNotFoundException;
use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Domain\Product\SimpleFactory\Product as FactorySimpleProduct;
use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;
use TechChallenge\Domain\Category\DAO\ICategory as ICategoryDAO;
use TechChallenge\Application\DTO\Product\DtoInput;

final class Store
{
    private IProductRepository $ProductRepository;

    private ICategoryDAO $CategoryDAO;

    public function __construct(AbstractFactoryRepository $AbstractFactoryRepository)
    {
        $this->ProductRepository = $AbstractFactoryRepository->createProductRepository();

        $this->CategoryDAO = $AbstractFactoryRepository->getDAO()->createCategoryDAO();
    }

    public function execute(DtoInput $data): string
    {
        $productFactory = (new FactorySimpleProduct())
            ->new()
            ->withNameDescriptionPriceImage($data->name, $data->description, $data->price, $data->image);

        if (!empty($data->categoryId)) {
            if (!$this->CategoryDAO->exist(["id" => $data->categoryId]))
                throw new CategoryNotFoundException();
            $productFactory->withCategoryId($data->categoryId);
        }

        $product = $productFactory->build();

        $this->ProductRepository->store($product);

        return $product->getId();
    }
}
