<?php

namespace TechChallenge\Application\AbstractFactory;

use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;
use TechChallenge\Adapters\Gateways\Repository\Eloquent\Customer\Repository as EloquentCustomerRepository;
use TechChallenge\Domain\Category\Repository\ICategory as ICategoryRepository;
use TechChallenge\Adapters\Gateways\Repository\Eloquent\Category\Repository as EloquentCategoryRepository;
use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;
use TechChallenge\Adapters\Gateways\Repository\Eloquent\Product\Repository as EloquentProductRepository;

class EloquentRepository extends AbstractFactoryRepository
{
    public function createCustomerRepository(): ICustomerRepository
    {
        return new EloquentCustomerRepository($this->DAO->createCustomerDAO());
    }

    public function createCategoryRepository(): ICategoryRepository
    {
        return new EloquentCategoryRepository($this->DAO->createCategoryDAO());
    }

    public function createProductRepository(): IProductRepository
    {
        return new EloquentProductRepository($this->DAO->createProductDAO());
    }
}
