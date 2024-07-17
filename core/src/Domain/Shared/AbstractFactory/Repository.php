<?php

namespace TechChallenge\Domain\Shared\AbstractFactory;

use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;
use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;
use TechChallenge\Domain\Category\Repository\ICategory as ICategoryRepository;
use TechChallenge\Domain\Order\Repository\IOrder as IOrderRepository;

abstract class Repository
{
    public function __construct(protected readonly DAO $DAO)
    {
    }

    public function getDAO()
    {
        return $this->DAO;
    }

    abstract public function createCustomerRepository(): ICustomerRepository;

    abstract public function createCategoryRepository(): ICategoryRepository;

    abstract public function createProductRepository(): IProductRepository;

    abstract public function createOrderRepository(): IOrderRepository;
}
