<?php

namespace TechChallenge\Adapters\Presenters\Traits;

trait ExecuteOnArray
{
    public function executeOnArray(array $entities): array
    {
        $array = [];

        foreach ($entities as $entity)
            $array[] = $this->execute($entity);

        return $array;
    }
}
