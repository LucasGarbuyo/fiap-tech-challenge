<?php

namespace TechChallenge\Application\AbstractFactory;

use TechChallenge\Domain\Shared\AbstractFactory\DAO as AbstractFactoryDAO;
use TechChallenge\Domain\Customer\DAO\ICustomer as ICustomerDAO;
use TechChallenge\Infra\DB\Eloquent\Customer\DAO as EloquentCustomerDAO;
use TechChallenge\Domain\Category\DAO\ICategory as ICategoryDAO;
use TechChallenge\Infra\DB\Eloquent\Category\DAO as EloquentCategoryDAO;
use TechChallenge\Domain\Product\DAO\IProduct as IProductDAO;
use TechChallenge\Infra\DB\Eloquent\Product\DAO as EloquentProductDAO;
use TechChallenge\Domain\Order\DAO\IOrder as IOrderDAO;
use TechChallenge\Infra\DB\Eloquent\Order\DAO as EloquentOrderDAO;

class EloquentDAO implements AbstractFactoryDAO
{
    public function createCustomerDAO(): ICustomerDAO
    {
        return new EloquentCustomerDAO();
    }

    public function createCategoryDAO(): ICategoryDAO
    {
        return new EloquentCategoryDAO();
    }

    public function createProductDAO(): IProductDAO
    {
        return new EloquentProductDAO();
    }

    public function createOrderDAO(): IOrderDAO
    {
        return new EloquentOrderDAO();
    }
}
