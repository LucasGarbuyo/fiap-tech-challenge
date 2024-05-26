<?php

namespace TechChallenge\Domain\Product\UseCase;

use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;
use TechChallenge\Domain\Category\Repository\ICategory as ICategoryRepository;

interface Store
{
    public function __construct(
        IProductRepository $ProductRepository,
        ICategoryRepository $CategoryRepository
    );

    public function execute(DtoInput $data): string;
}
