<?php

namespace TechChallenge\Application\UseCase\Product;

use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;

class Delete
{
    private IProductRepository $ProductRepository;

    public function __construct(IProductRepository $ProductRepository)
    {
        $this->ProductRepository = $ProductRepository;
    }

    public function execute(Dto $data)
    {
        $product = $this->ProductRepository->edit($data->id);

        $product->delete();

        $this->ProductRepository->delete($product);
    }
}
