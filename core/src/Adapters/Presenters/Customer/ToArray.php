<?php

namespace TechChallenge\Adapters\Presenters\Customer;

use TechChallenge\Adapters\Presenters\Traits\ExecuteOnArray as ExecuteOnArrayTrait;
use TechChallenge\Domain\Customer\Entities\Customer as CustomerEntity;

class ToArray
{
    use ExecuteOnArrayTrait;

    public function execute(CustomerEntity $customer): array
    {
        return [
            "id" => $customer->getId(),
            "name" => $customer->getName(),
            "cpf" => (string) $customer->getCpf(),
            "email" => (string) $customer->getEmail(),
            "created_at" => $customer->getCreatedAt() ? $customer->getCreatedAt()->format("Y-m-d H:i:s") : null,
            "updated_at" => $customer->getUpdatedAt() ? $customer->getUpdatedAt()->format("Y-m-d H:i:s") : null,
            "deleted_at" => $customer->getDeletedAt() ? $customer->getDeletedAt()->format("Y-m-d H:i:s") : null,
        ];
    }
}
