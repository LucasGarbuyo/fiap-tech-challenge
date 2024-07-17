<?php

namespace TechChallenge\Adapters\Controllers\Order;

use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Application\DTO\Order\DtoInput as OrderDTOInput;
use TechChallenge\Application\UseCase\Order\Update as UseCaseOrderUpdate;

final class Update
{
    public function __construct(private readonly AbstractFactoryRepository $AbstractFactoryRepository)
    {
    }

    public function execute(OrderDTOInput $dto)
    {
        return (new UseCaseOrderUpdate($this->AbstractFactoryRepository))->execute($dto);
    }
}
