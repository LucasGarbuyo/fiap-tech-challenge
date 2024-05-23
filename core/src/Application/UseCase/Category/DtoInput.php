<?php

namespace TechChallenge\Application\UseCase\Category;

use TechChallenge\Domain\Category\UseCase\DtoInput as ICategoryUseCaseDtoInput;

class DtoInput implements ICategoryUseCaseDtoInput
{
    public readonly ?string $id;
    public readonly ?string $name;
    public readonly ?string $type;
    public readonly ?string $created_at;
    public readonly ?string $updated_at;

    public function __construct(?string $id = null, ?string $name = null, ?string $type = null, ?string $created_at = null, ?string $updated_at = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
}
