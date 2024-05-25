<?php

namespace TechChallenge\Application\UseCase\Order;

use TechChallenge\Domain\Order\Factories\Order as OrderFactory;
use TechChallenge\Domain\Order\UseCase\DtoInput;
use TechChallenge\Domain\Order\UseCase\Store as IOrderUseCaseStore;
use TechChallenge\Domain\Order\Repository\IOrder as IOrderRepository;
use TechChallenge\Domain\Product\Repository\IProduct as IProductRepository;
use TechChallenge\Domain\Order\Entities\Item;

class Store extends IOrderUseCaseStore
{
    public function __construct(
        protected readonly IOrderRepository $orderRepository,
        protected readonly IProductRepository $productRepository
    ) {
    }
    public function execute(DtoInput $data): string
    {
        $orderFactory = (new OrderFactory())
            ->new();

        if (!is_null($data->getCustomerId())) {
            $orderFactory->withCustomerId($data->getCustomerId());
        }

        if (!empty($data->getItems())) {
            foreach ($data->getItems() as $item) {
                $product = $this->productRepository->show($item['productId']);
                $items[] = Item::create(
                    productId: $item['productId'],
                    quantity: $item['quantity'],
                    productPrice: $product->getPrice(),
                );
            }
            $orderFactory->withItems($items);
        }


        $order = $orderFactory->build();

        $this->orderRepository->store($order);

        return $order->getId();
    }
}
