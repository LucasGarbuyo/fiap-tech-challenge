<?php

namespace TechChallenge\Application\UseCase\Product;

use TechChallenge\Domain\Product\UseCase\DtoInput as IProductUseCaseDtoInput;

class DtoInput implements IProductUseCaseDtoInput
{
    public readonly ?string $id;
    public readonly ?string $category_id;
    public readonly ?string $name;
    public readonly ?string $description;
    public readonly ?float $price;
    public readonly ?string $image;
    public readonly ?string $created_at;
    public readonly ?string $updated_at;

    public function __construct(
        ?string $id = null,
        ?string $category_id = null,
        ?string $name = null,
        ?string $description = null,
        ?float $price = null,
        ?string $image = null,
        ?string $created_at = null,
        ?string $updated_at = null
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
