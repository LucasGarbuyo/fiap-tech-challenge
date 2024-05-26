<?php

namespace TechChallenge\Domain\Order\UseCase;

abstract class Index extends Standard
{
    abstract public function execute(array $filters = [], array|bool $append = []): array;
}
