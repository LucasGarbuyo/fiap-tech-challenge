<?php

namespace TechChallenge\Application\UseCase\Product;

use TechChallenge\Domain\Product\UseCase\DtoInput as IProductUseCaseDtoInput;

class DtoInput implements IProductUseCaseDtoInput
{
    public $id;
    public $category_id;
    public $name;
    public $description;
    public $price;
    public $image;
    public $created_at;
    public $updated_at;

    public function __construct(
        $id = null,
        $category_id = null,
        $name = null,
        $description = null,
        $price = null,
        $image = null,
        $created_at = null,
        $updated_at = null
    ) {
        $this->id = $id;
        $this->category_id = $category_id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->image = $image;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
}
