<?php

namespace TechChallenge\Application\UseCase\Product;

class Dto
{
    public ?string $id;
    public ?string $name;
    public ?string $description;
    public ?float $price;

    public function __construct(?string $id, ?string $name, ?string $description, ?float $price)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
    }
}
