<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('status_id')->constrained('order_statuses');
            $table->foreignId('user_id')->constrained('users');
            $table->string('address');
            $table->string('phoneNumber');
            $table->time('deliveryTime');
            $table->string('email')->nullable();
            $table->integer('totalPrice');
            $table->text('comment')->nullable();
            $table->timestamps();
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
