<?php

namespace TechChallenge\Domain\Category\UseCase;

abstract class Index extends Standard
{
    abstract public function execute(array $filters = [], array|bool $append = []): array; 
}
