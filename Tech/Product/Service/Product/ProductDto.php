<?php

namespace Tech\Product\Service\Product;

class ProductDto
{
    public string $name;
    public string $description;
    public float $price;

    public function __construct(string $name, string $description, float $price)
    {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
    }
}
