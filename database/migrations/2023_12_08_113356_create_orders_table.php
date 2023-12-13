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
            $table->id();
            $table->foreignId('bill_id');
            $table->foreignId('customer_id');
            $table->foreignId('user_id');
            $table->foreignId('category_id');
            $table->foreignId('menu_item_id');
            $table->foreignId('order_type_id');
            $table->foreignId('desk_id');
            $table->foreignId('order_status_id');
            $table->string('notes');
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
