<?php

namespace TechChallenge\Application\UseCase\Customer;

use TechChallenge\Domain\Customer\UseCase\Index as ICustomerUseCaseEdit;

class Index extends ICustomerUseCaseEdit
{
    public function execute(array $filters = [], array|bool $append = []): array
    {
        return $this->CustomerRepository->index($filters, $append);
    }
}
