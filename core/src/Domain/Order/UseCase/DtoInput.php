<?php

namespace TechChallenge\Domain\Order\UseCase;

interface DtoInput
{
    public function getCustomerId(): string;
    public function getItems(): array;
}
