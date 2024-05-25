<?php

namespace TechChallenge\Domain\Order\UseCase;

interface DtoInput
{
    public function getCustomerId(): string|null;

    public function getItems(): array|null;
}
