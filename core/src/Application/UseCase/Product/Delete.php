<?php

namespace TechChallenge\Application\UseCase\Product;

use TechChallenge\Domain\Product\UseCase\Delete as IProductUseCaseDelete;
use TechChallenge\Domain\Product\UseCase\DtoInput;

class Delete extends IProductUseCaseDelete
{
    public function execute(DtoInput $data): void
    {
        $product = $this->ProductRepository->edit($data->id);

        $product->delete();

        $this->ProductRepository->delete($product);
    }
}
