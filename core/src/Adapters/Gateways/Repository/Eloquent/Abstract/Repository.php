<?php

namespace TechChallenge\Adapters\Gateways\Repository\Eloquent\Abstract;

abstract class Repository
{
    protected function toEntities(array $datas): array
    {
        $entities = [];

        foreach ($datas as $data)
            $entities[] = $this->toEntity($data);

        return $entities;
    }

    protected function isPaginated(array $results): bool
    {
        return isset($results["data"]) && isset($results["pagination"]) && count($results["pagination"]) === 6;
    }

    abstract protected function toEntity(array $data);
}
