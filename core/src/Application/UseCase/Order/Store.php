<?php

namespace TechChallenge\Application\UseCase\Order;

use TechChallenge\Domain\Customer\Exceptions\CustomerNotFoundException;
use TechChallenge\Domain\Order\Factories\{Order as OrderFactory, Item as ItemFactory};
use TechChallenge\Domain\Order\UseCase\{DtoInput, Store as IOrderUseCaseStore};
use TechChallenge\Domain\Order\Repository\IOrder as IOrderRepository;
use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;
use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;
use TechChallenge\Domain\Product\Exceptions\ProductNotFoundException;

class Store implements IOrderUseCaseStore
{
    public function __construct(
        protected readonly IOrderRepository $orderRepository,
        protected readonly IProductRepository $productRepository,
        protected readonly ICustomerRepository $CustomerRepository
    ) {
    }

    public function execute(DtoInput $data): string
    {
        $orderFactory = (new OrderFactory())
            ->new();

        if (!is_null($data->getCustomerId())) {
            if (!$this->CustomerRepository->exist(["id" => $data->getCustomerId()]))
                throw new CustomerNotFoundException();

            $orderFactory->withCustomerId($data->getCustomerId());
        }

        if (!empty($data->getItems())) {
            $items = [];

            foreach ($data->getItems() as $item) {

                $product = $this->productRepository->show($item['product_id']);

                if (empty($product))
                    throw new ProductNotFoundException();

                $items[] = (new ItemFactory())
                    ->new()
                    ->withProductIdQuantityPrice($item['product_id'], $item['quantity'], $product->getPrice()->getValue())
                    ->build();
            }

            $orderFactory->withItems($items);
        }

        $order = $orderFactory->build();

        $this->orderRepository->store($order);

        return $order->getId();
    }
}
