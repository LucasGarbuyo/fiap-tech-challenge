<?php

namespace TechChallenge\Application\UseCase\Product;

use TechChallenge\Domain\Category\Exceptions\CategoryNotFoundException;
use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Domain\Product\SimpleFactory\Product as FactorySimpleProduct;
use TechChallenge\Domain\Product\DAO\IProduct as IProductDAO;
use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;
use TechChallenge\Domain\Product\Factories\Product as ProductFactory;
use TechChallenge\Domain\Category\Repository\ICategory as ICategoryRepository;
use TechChallenge\Application\DTO\Product\DtoInput;

final class Store
{
    private readonly IProductDAO $ProductDAO;
    private readonly IProductRepository $ProductRepository;
    private readonly ICategoryRepository $CategoryRepository;

    public function __construct(AbstractFactoryRepository $AbstractFactoryRepository)
    {
        $this->ProductDAO = $AbstractFactoryRepository->getDAO()->createProductDAO();
        $this->ProductRepository = $AbstractFactoryRepository->createProductRepository();
        $this->CategoryRepository = $AbstractFactoryRepository->createCategoryRepository();
    }

    public function execute(DtoInput $data): string
    {

/*        $product = (new FactorySimpleProduct())
            ->new()
            ->withNameDescriptionPriceImage($data->name, $data->description, $data->price, $data->image)
            ->build();

        dd($product);
        $this->ProductRepository->store($product);

        return $product->getId();
        */
        $productFactory = (new FactorySimpleProduct())
            ->new()
            ->withNameDescriptionPriceImage($data->name, $data->description, $data->price, $data->image);

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
