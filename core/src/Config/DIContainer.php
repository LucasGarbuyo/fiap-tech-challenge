<?php

namespace TechChallenge\Config;

use DI\ContainerBuilder;

//Product
use TechChallenge\Adapter\Driven\Infra\Repository\Product\Repository as ProductRepository;
use TechChallenge\Domain\Product\Repository\IProduct;

//Customer
use TechChallenge\Adapter\Driven\Infra\Repository\Customer\Repository as CustomerRepository;
use TechChallenge\Domain\Customer\Repository\ICustomer;

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
            IProduct::class => \DI\get(ProductRepository::class),
            ICustomer::class => \DI\get(CustomerRepository::class),
        ]);
    }
}
