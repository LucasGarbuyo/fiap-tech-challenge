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
        Schema::create('orders', function (Blueprint $table) {
            $table->char("id", 41)->primary(true)->unique()->index();
            $table->char('customer_id', 41)->nullable()->constrained('customers', 'id')->index();
            $table->decimal('total')->nullable();
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
        Schema::dropIfExists('orders');
    }
};
