<?php

namespace TechChallenge\Infra\DB\Eloquent\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel
{
    use HasFactory;

    protected $table = "customers";

    protected $fillable = ["id", "name", "email", "cpf", "created_at", "updated_at", "deleted_at"];
}
