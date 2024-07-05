<?php

namespace TechChallenge\Application\AbstractFactory;

use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;
use TechChallenge\Adapters\Gateways\Repository\Eloquent\Customer\Repository as EloquentCustomerRepository;
use TechChallenge\Domain\Category\Repository\ICategory as ICategoryRepository;
use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;
use TechChallenge\Adapters\Gateways\Repository\Eloquent\Product\Repository as EloquentProductRepository;
use TechChallenge\Domain\Shared\Exceptions\DefaultException;

class EloquentRepository extends AbstractFactoryRepository
{
    public function createCustomerRepository(): ICustomerRepository
    {
        return new EloquentCustomerRepository($this->DAO->createCustomerDAO());
    }

    public function createCategoryRepository(): ICategoryRepository
    {
        throw new DefaultException("not implemented");
    }

    public function createProductRepository(): IProductRepository
    {
        return new EloquentProductRepository($this->DAO->createProductDAO());
    }
}
