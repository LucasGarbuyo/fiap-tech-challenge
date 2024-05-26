<?php

namespace TechChallenge\Application\UseCase\OrderItem;

use TechChallenge\Domain\Order\UseCase\DtoInput;
use TechChallenge\Domain\Order\Entities\Item as OrderItemEntity;
use TechChallenge\Domain\OrderItem\UseCase\Show as IOrderItemUseCaseShow;
use TechChallenge\Adapter\Driven\Infra\Repository\Item\Repository as OrderItemRepository;

class Show extends IOrderItemUseCaseShow
{
    private $orderItemRepository;

    public function __construct(OrderItemRepository $orderItemRepository)
    {
        $this->orderItemRepository = $orderItemRepository;
    }

    public function execute(DtoInput $data): OrderItemEntity
    {
        return $this->orderItemRepository->show($data->id);
    }
}