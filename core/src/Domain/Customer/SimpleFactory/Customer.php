<?php

namespace TechChallenge\Domain\Customer\SimpleFactory;

use DateTime;
use TechChallenge\Domain\Customer\Entities\Customer as CustomerEntity;
use TechChallenge\Domain\Customer\ValueObjects\Cpf;
use TechChallenge\Domain\Customer\ValueObjects\Email;

class Customer
{
    private CustomerEntity $customer;

    public function new(?string $id = null, String|DateTime $createdAt = null, String|DateTime $updatedAt = null): self
    {
        if (!is_null($createdAt))
            $createdAt = is_string($createdAt) ? new DateTime($createdAt) : $createdAt;

        if (!is_null($updatedAt))
            $updatedAt = is_string($updatedAt) ? new DateTime($updatedAt) : $updatedAt;

        $this->customer = CustomerEntity::create($id, $createdAt, $updatedAt);

        return $this;
    }

    public function restore(?string $id = null, String|DateTime $createdAt = null, String|DateTime $updatedAt = null): self
    {
        if (!is_null($createdAt))
            $createdAt = is_string($createdAt) ? new DateTime($createdAt) : $createdAt;

        if (!is_null($updatedAt))
            $updatedAt = is_string($updatedAt) ? new DateTime($updatedAt) : $updatedAt;


        $this->customer = new CustomerEntity($id, $createdAt, $updatedAt);

        return $this;
    }


    public function withNameCpfEmail(string|null $name, string|null $cpf, string|null $email): self
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
