<?php

namespace TechChallenge\Domain\OrderItem\UseCase;

interface DtoInput
{
    public function getCustomerId(): string|null;

    public function getItems(): array|null;
}
