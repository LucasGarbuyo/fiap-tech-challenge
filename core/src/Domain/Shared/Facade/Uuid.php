<?php

namespace TechChallenge\Domain\Shared\Facade;

use TechChallenge\Domain\Shared\Exceptions\DefaultException;
use Ramsey\Uuid\Uuid as RamseyUuid;

final class Uuid
{
    public static function generate(string $prefix): string
    {
        if (strlen($prefix) != 4)
            throw new DefaultException("Prefixo do ID precisa ter 4 caracteres");

        $prefix = strtoupper($prefix);

        $uuid = RamseyUuid::uuid4();

        $maxLength = 28;
        $result = "{$prefix}_{$uuid->toString()}";
        if (strlen($result) > $maxLength) {
            $result = substr($result, 0, $maxLength);
        }

        return $result;
    }
}
