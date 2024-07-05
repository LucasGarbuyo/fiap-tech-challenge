<?php

namespace TechChallenge\Domain\Shared\AbstractFactory;

use TechChallenge\Domain\Customer\DAO\ICustomer as ICustomerDAO;
use TechChallenge\Domain\Product\DAO\IProduct as IProductDAO;
use TechChallenge\Domain\Category\DAO\ICategory as ICategoryDAO;

interface DAO
{
    public function createCustomerDAO(): ICustomerDAO;

    public function createCategoryDAO(): ICategoryDAO;

    public function createProductDAO(): IProductDAO;
}
