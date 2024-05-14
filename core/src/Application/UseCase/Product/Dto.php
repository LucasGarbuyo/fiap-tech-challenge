<?php

namespace TechChallenge\Application\UseCase\Product;

class Dto
{
    public readonly ?string $id;
    public readonly ?string $name;
    public readonly ?string $description;
    public readonly ?float $price;
    public readonly ?string $created_at;
    public readonly ?string $updated_at;

    public function __construct(
        ?string $id = null,
        ?string $name = null,
        ?string $description = null,
        ?float $price = null,
        ?string $created_at = null,
        ?string $updated_at = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
}
