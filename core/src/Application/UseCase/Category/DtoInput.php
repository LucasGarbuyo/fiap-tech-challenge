<?php

namespace TechChallenge\Application\UseCase\Category;

use TechChallenge\Domain\Category\UseCase\DtoInput as ICategoryUseCaseDtoInput;

class DtoInput implements ICategoryUseCaseDtoInput
{
    public $id;
    public $name;
    public $type;
    public $created_at;
    public $updated_at;

    public function __construct($id = null,  $name = null,  $type = null,  $created_at = null,  $updated_at = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
}
