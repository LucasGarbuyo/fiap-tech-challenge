<?php

namespace TechChallenge\Domain\Product\UseCase;

use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;

interface Delete
{
    public function __construct(IProductRepository $ProductRepository);

    public function execute(DtoInput $data): void;
}
