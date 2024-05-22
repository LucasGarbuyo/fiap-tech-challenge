<?php

namespace TechChallenge\Config;

use DI\ContainerBuilder;

//Product
use TechChallenge\Adapter\Driven\Infra\Repository\Product\Repository as ProductRepository;
use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;

//Customer
use TechChallenge\Adapter\Driven\Infra\Repository\Customer\Repository as CustomerRepository;
use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;

//Customer UseCase
use TechChallenge\Domain\Customer\UseCase\Index as ICustomerUseCaseIndex;
use TechChallenge\Application\UseCase\Customer\Index as CustomerUseCaseIndex;

use TechChallenge\Domain\Customer\UseCase\Edit as ICustomerUseCaseEdit;
use TechChallenge\Application\UseCase\Customer\Edit as CustomerUseCaseEdit;

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

use TechChallenge\Domain\Product\UseCase\Edit as IProductUseCaseEdit;
use TechChallenge\Application\UseCase\Product\Edit as ProductUseCaseEdit;

use TechChallenge\Domain\Product\UseCase\Store as IProductUseCaseStore;
use TechChallenge\Application\UseCase\Product\Store as ProductUseCaseStore;

use TechChallenge\Domain\Product\UseCase\Update as IProductUseCaseUpdate;
use TechChallenge\Application\UseCase\Product\Update as ProductUseCaseUpdate;

use TechChallenge\Domain\Product\UseCase\Delete as IProductUseCaseDelete;
use TechChallenge\Application\UseCase\Product\Delete as ProductUseCaseDelete;

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

            //Customer UseCase
            ICustomerUseCaseIndex::class => \DI\get(CustomerUseCaseIndex::class),
            ICustomerUseCaseEdit::class => \DI\get(CustomerUseCaseEdit::class),
            ICustomerUseCaseStore::class => \DI\get(CustomerUseCaseStore::class),
            ICustomerUseCaseUpdate::class => \DI\get(CustomerUseCaseUpdate::class),
            ICustomerUseCaseDelete::class => \DI\get(CustomerUseCaseDelete::class),
            ICustomerUseCaseEditByCpf::class => \DI\get(CustomerUseCaseEditByCpf::class),

            //Product UseCase
            IProductUseCaseIndex::class => \DI\get(ProductUseCaseIndex::class),
            IProductUseCaseEdit::class => \DI\get(ProductUseCaseEdit::class),
            IProductUseCaseStore::class => \DI\get(ProductUseCaseStore::class),
            IProductUseCaseUpdate::class => \DI\get(ProductUseCaseUpdate::class),
            IProductUseCaseDelete::class => \DI\get(ProductUseCaseDelete::class),
        ]);
    }
}
