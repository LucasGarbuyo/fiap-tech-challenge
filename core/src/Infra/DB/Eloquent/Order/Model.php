<?php

namespace TechChallenge\Infra\DB\Eloquent\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use TechChallenge\Infra\DB\Eloquent\Order\Item\Model as OrderItemModel;
use TechChallenge\Infra\DB\Eloquent\Order\Status\Model as OrderStatusModel;
use TechChallenge\Infra\DB\Eloquent\Customer\Model as CustomerModel;

class Model extends EloquentModel
{
    use HasFactory, SoftDeletes;

    protected $table = "orders";

    protected $fillable = [
        "id",
        "customer_id",
        "total",
        "status",
        "created_at",
        "updated_at",
        "deleted_at"
    ];

    // Desativando a auto-incrementação da chave primária
    public $incrementing = false;

    // Definindo o tipo da chave primária
    protected $keyType = 'string';

    public function items()
    {
        return $this->hasMany(OrderItemModel::class, "order_id", "id");
    }

    public function statusHistory()
    {
        return $this->hasMany(OrderStatusModel::class, "order_id", "id");
    }

    public function customer()
    {
        return $this->hasOne(CustomerModel::class, "id", "customer_id");
    }
}
