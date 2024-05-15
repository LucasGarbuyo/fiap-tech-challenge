<?php

namespace TechChallenge\Domain\Customer\Factories;

use DateTime;
use TechChallenge\Domain\Customer\Entities\Customer as CustomerEntity;
use TechChallenge\Domain\Customer\ValueObjects\Cpf;
use TechChallenge\Domain\Customer\ValueObjects\Email;

class Customer
{
    private CustomerEntity $customer;

    public function new(?string $id = null, String|DateTime $created_at = null, String|DateTime $updated_at = null): self
    {
        if (!is_null($created_at))
            $created_at = is_string($created_at) ? new DateTime($created_at) : $created_at;

        if (!is_null($updated_at))
            $updated_at = is_string($updated_at) ? new DateTime($updated_at) : $updated_at;

        $this->customer = CustomerEntity::create($id, $created_at, $updated_at);

        return $this;
    }

    public function withNameCpfEmail(string $name, string $cpf, string $email): self
    {
        $this->customer
            ->setName($name)
            ->setCpf(new Cpf($cpf))
            ->setEmail(new Email($email));

        return $this;
    }

    public function build(): CustomerEntity
    {
        return $this->customer;
    }
}
