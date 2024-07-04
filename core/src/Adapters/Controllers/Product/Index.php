<?php

namespace TechChallenge\Adapters\Controllers\Product;

use TechChallenge\Domain\Product\DAO\IProduct as IProductDAO;
use TechChallenge\Infra\DB\Eloquent\Product\DAO;
use TechChallenge\Adapters\Gateways\Repository\Product\Repository as ProductRepository;
use TechChallenge\Application\UseCase\Product\Index as UseCaseProductIndex;

final class Index
{
    private DAO $ProductDAO;

    public function __construct(DAO $ProductDAO)
    {
        $this->ProductDAO = $ProductDAO;
    }

    public function execute(array $filters)
    {
        return (new UseCaseProductIndex((new ProductRepository($this->ProductDAO))))->execute($filters);
    }
}
