<?php

namespace TechChallenge\Application\UseCase\Product;

use TechChallenge\Domain\Product\Entities\Product as ProductEntity;
use TechChallenge\Domain\Product\UseCase\DtoInput;
use TechChallenge\Domain\Product\UseCase\Edit as IProductUseCaseEdit;

class Edit extends IProductUseCaseEdit
{
    public function execute(DtoInput $data): ProductEntity
    {
        return $this->ProductRepository->edit($data->id);
    }
}
