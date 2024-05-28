<?php

namespace TechChallenge\Domain\Order\UseCase;

interface DtoInput
{
    public function getId(): ?string;

    public function getCustomerId(): ?string;

    public function getItems(): array;

    public function getStatus(): ?string;
}
