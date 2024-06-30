<?php

namespace TechChallenge\Adapters\Presenters\Customer;

use TechChallenge\Domain\Customer\Entities\Customer as CustomerEntity;

class ToJson
{
    public function executeOnArray(array $entities): string
    {
        return json_encode((new ToArray())->executeOnArray($entities));
    }

    public function execute(CustomerEntity $customer): string
    {
        return json_encode((new ToArray())->execute($customer));
    }
}
