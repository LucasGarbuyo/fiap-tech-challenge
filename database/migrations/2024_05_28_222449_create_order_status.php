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
        Schema::create('order_status', function (Blueprint $table) {
            $table->char("id", 41)->primary(true)->unique();
            $table->char('order_id', 41)->nullable()->constrained('orders', 'id')->index();
            $table->enum('status', [
                'NEW',
                'RECEIVED',
                'PAID',
                'IN_PREPARATION',
                'READY',
                'FINISHED',
                'CANCELED',
            ]);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_status');
    }
};
