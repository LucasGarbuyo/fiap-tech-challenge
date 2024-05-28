<?php

namespace TechChallenge\Domain\Order\UseCase;

use TechChallenge\Domain\Order\Repository\IOrder as IOrderRepository;
use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;
use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;

interface Store
{
    public function __construct(
        IOrderRepository $OrderRepository,
        IProductRepository $ProductRepository,
        ICustomerRepository $CustomerRepository
    );

    public function execute(DtoInput $data): string;
}
