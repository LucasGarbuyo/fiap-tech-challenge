<?php

namespace TechChallenge\Application\UseCase\Product;

// use TechChallenge\Domain\Category\Exceptions\CategoryNotFoundException;
use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Domain\Product\SimpleFactory\Product as FactorySimpleProduct;
use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;
use TechChallenge\Domain\Category\Repository\ICategory as ICategoryRepository;
use TechChallenge\Application\DTO\Product\DtoInput;

final class Store
{
    private IProductRepository $ProductRepository;
    private ICategoryRepository $CategoryRepository;

    public function __construct(AbstractFactoryRepository $AbstractFactoryRepository)
    {
        $this->ProductRepository = $AbstractFactoryRepository->createProductRepository();
        //$this->CategoryRepository = $AbstractFactoryRepository->createCategoryRepository();
    }

    public function execute(DtoInput $data): string
    {
        $productFactory = (new FactorySimpleProduct())
            ->new()
            ->withCategoryId($data->category_id)
            ->withNameDescriptionPriceImage($data->name, $data->description, $data->price, $data->image);

        // TODO - ADICIONAR A CATEGORIA QUANDO AbstractFactoryRepository ESTIVER IMPLEMENTADO
        /*if (!empty($data->category_id)) {
            if (!$this->CategoryRepository->exist(["id" => $data->category_id]))
                throw new CategoryNotFoundException();
            $productFactory->withCategoryId($data->category_id);
        }*/

        $product = $productFactory->build();

        $this->ProductRepository->store($product);

        return $product->getId();
    }
}
