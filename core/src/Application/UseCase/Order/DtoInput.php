<?php

namespace TechChallenge\Application\UseCase\Order;

use TechChallenge\Domain\Order\UseCase\DtoInput as IOrderUseCaseDtoInput;

class DtoInput implements IOrderUseCaseDtoInput
{
    public readonly ?string $id;
    public readonly ?string $customerId;
    public readonly ?array $items;

    public function __construct(
        ?string $id = null,
        ?string $customerId = null,
        ?array $items = [],
    ) {
        $this->id = $id;
        $this->customerId = $customerId;
        $this->items = $items;
    }
}
