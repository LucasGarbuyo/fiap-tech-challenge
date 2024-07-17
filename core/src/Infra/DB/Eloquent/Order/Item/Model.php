<?php

namespace TechChallenge\Infra\DB\Eloquent\Order\Item;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Model extends EloquentModel
{
    use HasFactory, SoftDeletes;

    protected $table = "order_items";

    protected $fillable = [
        "id",
        "order_id",
        "product_id",
        "quantity",
        "price",
        "created_at",
        "updated_at",
        "deleted_at"
    ];

    // Desativando a auto-incrementação da chave primária
    public $incrementing = false;

    // Definindo o tipo da chave primária
    protected $keyType = 'string';
}
