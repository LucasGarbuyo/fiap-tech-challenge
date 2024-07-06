<?php

namespace TechChallenge\Application\UseCase\Product;

// use TechChallenge\Domain\Category\Exceptions\CategoryNotFoundException;
// use TechChallenge\Domain\Category\Repository\ICategory as ICategoryRepository;
use TechChallenge\Domain\Product\DAO\IProduct as IProductDAO;
use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Domain\Product\SimpleFactory\Product as FactorySimpleProduct;
use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;
use TechChallenge\Application\DTO\Product\DtoInput;
use TechChallenge\Domain\Product\Exceptions\ProductNotFoundException;
use DateTime;

final class Update
{
    private IProductRepository $ProductRepository;
    private readonly IProductDAO $ProductDAO;
    // private ICategoryRepository $CategoryRepository;

    public function __construct(AbstractFactoryRepository $AbstractFactoryRepository)
    {
        $this->ProductDAO = $AbstractFactoryRepository->getDAO()->createProductDAO();
        $this->ProductRepository = $AbstractFactoryRepository->createProductRepository();
        //$this->CategoryRepository = $AbstractFactoryRepository->createCategoryRepository();
    }

    public function execute(DtoInput $data): void
    {
        if (!$this->ProductDAO->exist(["id" => $data->id]))
            throw new ProductNotFoundException();

        $productFactory = (new FactorySimpleProduct())
            ->new($data->id, $data->created_at, $data->updated_at)
            ->withCategoryId($data->category_id)
            ->withNameDescriptionPriceImage($data->name, $data->description, $data->price, $data->image)
            ->build();

        // TODO - ADICIONAR A CATEGORIA QUANDO AbstractFactoryRepository ESTIVER IMPLEMENTADO
        /*if (!empty($data->category_id)) {
            if (!$this->CategoryRepository->exist(["id" => $data->category_id]))
                throw new CategoryNotFoundException();
            $productFactory->withCategoryId($data->category_id);
        }*/

        $productFactory->setUpdatedAt(new DateTime());

        $this->ProductRepository->update($productFactory);
    }
}
