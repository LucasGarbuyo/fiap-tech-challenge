<?php

namespace TechChallenge\Domain\Shared\Entities;

use DateTime;

abstract class Standard
{
    abstract public static function create(
        ?string $id = null,
        ?DateTime $createdAt = null,
        ?DateTime $updatedAt = null
    );
}
