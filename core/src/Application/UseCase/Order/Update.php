<?php

namespace TechChallenge\Application\UseCase\Order;

use TechChallenge\Domain\Customer\Exceptions\CustomerNotFoundException;
use TechChallenge\Domain\Order\UseCase\{DtoInput, Update as IOrderUseCaseUpdate};
use TechChallenge\Domain\Order\Repository\IOrder as IOrderRepository;
use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;
use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;
use TechChallenge\Domain\Order\Factories\Order as OrderFactory;
use TechChallenge\Domain\Order\Enum\OrderStatus;
use TechChallenge\Domain\Order\Exceptions\OrderException;
use ValueError;

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
        $order = (new OrderFactory())
            ->new();

        if (!is_null($data->getCustomerId())) {
            if (!$this->CustomerRepository->exist(["id" => $data->getCustomerId()]))
                throw new CustomerNotFoundException();

            $order->withCustomerId($data->getCustomerId());
        }

        try {
            OrderStatus::from($data->status);
        } catch (ValueError $error) {
            throw new OrderException("Status inválido");
        }
    }
}
