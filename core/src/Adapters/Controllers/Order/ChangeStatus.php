<?php

namespace TechChallenge\Adapters\Controllers\Order;

use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Application\UseCase\Order\ChangeStatus as UseCaseOrderChangeStatus;
use TechChallenge\Application\DTO\Order\DtoInput;

final class ChangeStatus
{
    public function __construct(private readonly AbstractFactoryRepository $AbstractFactoryRepository)
    {
    }

    public function execute(DtoInput $dto)
    {
        return (new UseCaseOrderChangeStatus($this->AbstractFactoryRepository))->execute($dto);
    }
}
