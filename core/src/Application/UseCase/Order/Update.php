<?php

namespace TechChallenge\Application\UseCase\Order;

use TechChallenge\Domain\Order\UseCase\{DtoInput, Update as IOrderUseCaseUpdate};
use TechChallenge\Domain\Order\Repository\IOrder as IOrderRepository;
use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;
use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;

class Update implements IOrderUseCaseUpdate
{
    public function __construct(
        protected readonly IOrderRepository $OrderRepository,
        protected readonly IProductRepository $ProductRepository,
        protected readonly ICustomerRepository $CustomerRepository
    ) {
    }

    public function execute(DtoInput $data): void
    {
    }
}
