<?php

namespace TechChallenge\Application\UseCase\Customer;

class Dto
{
    public readonly ?string $id;
    public readonly ?string $name;
    public readonly ?string $cpf;
    public readonly ?string $email;
    public readonly ?string $created_at;
    public readonly ?string $updated_at;

    public function __construct(?string $id = null, ?string $name = null, ?string $cpf = null, ?string $email = null, ?string $created_at = null, ?string $updated_at = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->cpf = $cpf;
        $this->email = $email;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
}
