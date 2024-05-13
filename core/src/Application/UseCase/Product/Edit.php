<?php

namespace TechChallenge\Application\UseCase\Product;

use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;
use TechChallenge\Domain\Product\Entities\Product;

class Edit
{
    private IProductRepository $ProductRepository;

    public function __construct(IProductRepository $ProductRepository)
    {
        $this->ProductRepository = $ProductRepository;
    }

    public function execute(Dto $data)
    {
        dd($data);die;
        $product = (new Product())
            ->getId($data->id);

        $this->ProductRepository->edit($product);
    }
    
}
