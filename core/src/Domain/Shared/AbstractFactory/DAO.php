<?php

namespace TechChallenge\Domain\Shared\AbstractFactory;

use TechChallenge\Domain\Customer\DAO\ICustomer as ICustomerDAO;
use TechChallenge\Domain\Product\DAO\IProduct as IProductDAO;
use TechChallenge\Domain\Category\DAO\ICategory as ICategoryDAO;
use TechChallenge\Domain\Order\DAO\IOrder as IOrderDAO;

interface DAO
{
    public function createCustomerDAO(): ICustomerDAO;

    public function createCategoryDAO(): ICategoryDAO;

    public function createProductDAO(): IProductDAO;

    public function createOrderDAO(): IOrderDAO;
    
}
