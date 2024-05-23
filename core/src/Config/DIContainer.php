<?php

namespace TechChallenge\Config;

use DI\ContainerBuilder;

//Product
use TechChallenge\Adapter\Driven\Infra\Repository\Product\Repository as ProductRepository;
use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;

//Category
use TechChallenge\Adapter\Driven\Infra\Repository\Category\Repository as CategoryRepository;
use TechChallenge\Domain\Category\Repository\ICategory as ICategoryRepository;

//Customer
use TechChallenge\Adapter\Driven\Infra\Repository\Customer\Repository as CustomerRepository;
use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;

//Customer UseCase
use TechChallenge\Domain\Customer\UseCase\Index as ICustomerUseCaseIndex;
use TechChallenge\Application\UseCase\Customer\Index as CustomerUseCaseIndex;

use TechChallenge\Domain\Customer\UseCase\Show as ICustomerUseCaseShow;
use TechChallenge\Application\UseCase\Customer\Show as CustomerUseCaseShow;

use TechChallenge\Domain\Customer\UseCase\Store as ICustomerUseCaseStore;
use TechChallenge\Application\UseCase\Customer\Store as CustomerUseCaseStore;

use TechChallenge\Domain\Customer\UseCase\Update as ICustomerUseCaseUpdate;
use TechChallenge\Application\UseCase\Customer\Update as CustomerUseCaseUpdate;

use TechChallenge\Domain\Customer\UseCase\Delete as ICustomerUseCaseDelete;
use TechChallenge\Application\UseCase\Customer\Delete as CustomerUseCaseDelete;

use TechChallenge\Domain\Customer\UseCase\EditByCpf as ICustomerUseCaseEditByCpf;
use TechChallenge\Application\UseCase\Customer\EditByCpf as CustomerUseCaseEditByCpf;

//Product UseCase
use TechChallenge\Domain\Product\UseCase\Index as IProductUseCaseIndex;
use TechChallenge\Application\UseCase\Product\Index as ProductUseCaseIndex;

use TechChallenge\Domain\Product\UseCase\Show as IProductUseCaseShow;
use TechChallenge\Application\UseCase\Product\Show as ProductUseCaseShow;

use TechChallenge\Domain\Product\UseCase\Store as IProductUseCaseStore;
use TechChallenge\Application\UseCase\Product\Store as ProductUseCaseStore;

use TechChallenge\Domain\Product\UseCase\Update as IProductUseCaseUpdate;
use TechChallenge\Application\UseCase\Product\Update as ProductUseCaseUpdate;

use TechChallenge\Domain\Product\UseCase\Delete as IProductUseCaseDelete;
use TechChallenge\Application\UseCase\Product\Delete as ProductUseCaseDelete;

//Category UseCase
use TechChallenge\Domain\Category\UseCase\Index as ICategoryUseCaseIndex;
use TechChallenge\Application\UseCase\Category\Index as CategoryUseCaseIndex;

use TechChallenge\Domain\Category\UseCase\Show as ICategoryUseCaseShow;
use TechChallenge\Application\UseCase\Category\Show as CategoryUseCaseShow;

use TechChallenge\Domain\Category\UseCase\Store as ICategoryUseCaseStore;
use TechChallenge\Application\UseCase\Category\Store as CategoryUseCaseStore;

use TechChallenge\Domain\Category\UseCase\Update as ICategoryUseCaseUpdate;
use TechChallenge\Application\UseCase\Category\Update as CategoryUseCaseUpdate;

use TechChallenge\Domain\Category\UseCase\Delete as ICategoryUseCaseDelete;
use TechChallenge\Application\UseCase\Category\Delete as CategoryUseCaseDelete;

class DIContainer
{
    private static ?ContainerBuilder $containerBuild = null;

    private function __construct()
    {
    }

    public static function create()
    {
        if (is_null(self::$containerBuild))
            self::load();

        return self::$containerBuild->build();
    }

    private static function load(): void
    {
        self::$containerBuild = new ContainerBuilder();

        self::$containerBuild->addDefinitions([
            //Entities
            IProductRepository::class => \DI\get(ProductRepository::class),
            ICustomerRepository::class => \DI\get(CustomerRepository::class),
            ICategoryRepository::class => \DI\get(CategoryRepository::class),

            //Customer UseCase
            ICustomerUseCaseIndex::class => \DI\get(CustomerUseCaseIndex::class),
            ICustomerUseCaseShow::class => \DI\get(CustomerUseCaseShow::class),
            ICustomerUseCaseStore::class => \DI\get(CustomerUseCaseStore::class),
            ICustomerUseCaseUpdate::class => \DI\get(CustomerUseCaseUpdate::class),
            ICustomerUseCaseDelete::class => \DI\get(CustomerUseCaseDelete::class),
            ICustomerUseCaseEditByCpf::class => \DI\get(CustomerUseCaseEditByCpf::class),

            //Product UseCase
            IProductUseCaseIndex::class => \DI\get(ProductUseCaseIndex::class),
            IProductUseCaseShow::class => \DI\get(ProductUseCaseShow::class),
            IProductUseCaseStore::class => \DI\get(ProductUseCaseStore::class),
            IProductUseCaseUpdate::class => \DI\get(ProductUseCaseUpdate::class),
            IProductUseCaseDelete::class => \DI\get(ProductUseCaseDelete::class),

            //Category UseCase
            ICategoryUseCaseIndex::class => \DI\get(CategoryUseCaseIndex::class),
            ICategoryUseCaseShow::class => \DI\get(CategoryUseCaseShow::class),
            ICategoryUseCaseStore::class => \DI\get(CategoryUseCaseStore::class),
            ICategoryUseCaseUpdate::class => \DI\get(CategoryUseCaseUpdate::class),
            ICategoryUseCaseDelete::class => \DI\get(CategoryUseCaseDelete::class),
        ]);
    }
}
