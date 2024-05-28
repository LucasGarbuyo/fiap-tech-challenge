<?php

namespace TechChallenge\Domain\Product\UseCase;

use TechChallenge\Domain\Product\Entities\Product as ProductEntity;
use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;

interface Show
{
    public function __construct(IProductRepository $ProductRepository);

    public function execute(DtoInput $data, array|bool $append = []): ProductEntity;
}
