<?php

namespace TechChallenge\Infra\DB\Eloquent\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Model extends EloquentModel
{
    use HasFactory, SoftDeletes;

    protected $table = "products";

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        "id",
        "category_id",
        "name",
        "description",
        "price",
        "image",
        "created_at",
        "updated_at",
        "deleted_at"
    ];
}
