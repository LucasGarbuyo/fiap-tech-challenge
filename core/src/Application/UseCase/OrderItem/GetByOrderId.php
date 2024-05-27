<?php

namespace TechChallenge\Application\UseCase\OrderItem;

use TechChallenge\Domain\Order\UseCase\DtoInput;
use Illuminate\Support\Collection;
use TechChallenge\Domain\OrderItem\UseCase\GetByOrderId as IOrderItemUseCaseGetByOrderId;
use TechChallenge\Adapter\Driven\Infra\Repository\Item\Repository as OrderItemRepository;

class GetByOrderId extends IOrderItemUseCaseGetByOrderId
{
    private $orderItemRepository;

    public function __construct(OrderItemRepository $orderItemRepository)
    {
        $this->orderItemRepository = $orderItemRepository;
    }

    public function execute(DtoInput $data): Collection
    {
        return $this->orderItemRepository->getByOrderId($data->id);
    }
}