<?php

namespace TechChallenge\Domain\Customer\UseCase;

abstract class Index extends Standard
{
    abstract public function execute(array $filters = [], array|bool $append = []): array;
}
