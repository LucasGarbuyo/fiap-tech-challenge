<?php

namespace TechChallenge\Application\UseCase\Product;

class Dto
{
    public ?string $id;
    public ?string $name;
    public ?string $description;
    public ?float $price;

    public function __construct(?string $id = null, ?string $name = null, ?string $description = null, ?float $price = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
    }
}
