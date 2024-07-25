<?php

namespace TechChallenge\Adapters\Controllers\MercadoPago;

use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Application\DTO\MercadoPago\DtoInput as MercadoPagoDTOInput;
use TechChallenge\Application\UseCase\MercadoPago\Update as UseCaseMercadoPagoUpdate;

final class Update
{
    public function __construct(private readonly AbstractFactoryRepository $AbstractFactoryRepository)
    {
    }

    public function execute(MercadoPagoDTOInput $dto)
    {
        return (new UseCaseMercadoPagoUpdate($this->AbstractFactoryRepository))->execute($dto);
    }
}
