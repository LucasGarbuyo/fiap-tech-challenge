<?php

namespace TechChallenge\Application\UseCase\Customer;

class Dto
{
    public readonly ?string $id;
    public readonly ?string $name;
    public readonly ?string $cpf;
    public readonly ?string $email;

    public function __construct(?string $id, ?string $name, ?string $cpf, ?string $email)
    {
        $this->id = $id;
        $this->name = $name;
        $this->cpf = $cpf;
        $this->email = $email;
    }
}
