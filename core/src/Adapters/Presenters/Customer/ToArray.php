<?php

namespace TechChallenge\Adapters\Presenters\Customer;

use TechChallenge\Adapters\Presenters\Traits\ExecuteOnArray as ExecuteOnArrayTrait;
use TechChallenge\Domain\Customer\Entities\Customer as CustomerEntity;

class ToArray
{
    use ExecuteOnArrayTrait;

    public function execute(CustomerEntity $customer): array
    {
        return [];
    }
}
