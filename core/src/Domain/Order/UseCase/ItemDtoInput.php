<?php

namespace TechChallenge\Domain\Order\UseCase;

interface ItemDtoInput
{
    public function getId(): ?string;

    public function getProductId(): ?string;

    public function getQuantity(): ?int;
}
