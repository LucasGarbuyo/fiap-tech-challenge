<?php

namespace TechChallenge\Application\UseCase\Product;

use TechChallenge\Domain\Product\Entities\Product;
use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;

class Edit
{
    private IProductRepository $ProductRepository;

    public function __construct(IProductRepository $ProductRepository)
    {
        $this->ProductRepository = $ProductRepository;
    }

    public function execute(Dto $data): Product
    {
        return $this->ProductRepository->edit($data->id);
    }
}
