<?php

namespace TechChallenge\Infra\DB\Eloquent\Category;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Model extends EloquentModel
{
    use HasFactory, SoftDeletes;

    protected $table = "categories";

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        "id",
        "name",
        "type",
        "created_at",
        "updated_at",
        "deleted_at"
    ];
}
