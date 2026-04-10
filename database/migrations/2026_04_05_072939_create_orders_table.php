<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->decimal('total_amount', 10, 2);
            $table->enum('status', [
                'pending',
                'confirmed',
                'preparing',
                'ready',
                'picked_up',
                'cancelled'
            ])->default('pending');
            $table->integer('queue_number')->nullable();
            $table->dateTime('order_time');
            $table->dateTime('pickup_time')->nullable();
            $table->text('special_notes')->nullable();
            $table->timestamps();
            
            // Indexes for better query performance
            $table->index('user_id');
            $table->index('status');
            $table->index('queue_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
