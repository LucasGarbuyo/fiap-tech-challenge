<?php

namespace TechChallenge\Domain\Order\Repository;

use TechChallenge\Domain\Order\Entities\Status;

interface IStatus
{
    public function index(array $filters = []): array;

    public function store(Status $status): void;
}
