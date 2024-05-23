<?php

namespace TechChallenge\Application\UseCase\Product;

use TechChallenge\Domain\Product\Entities\Product as ProductEntity;
use TechChallenge\Domain\Product\UseCase\DtoInput;
use TechChallenge\Domain\Product\UseCase\Show as IProductUseCaseShow;

class Show extends IProductUseCaseShow
{
    public function execute(DtoInput $data): ProductEntity
    {
        return $this->ProductRepository->show($data->id);
    }
}
