<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders_items', function (Blueprint $table) {
            $table->char("id", 28)->primary(true)->unique();
            $table->char('order_id', 28)->nullable()->constrained('orders', 'id')->index();
            $table->char('product_id', 28)->nullable()->constrained('products', 'id')->index();
            $table->integer('quantity')->nullable();
            $table->float('price')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders_items');
    }
};
