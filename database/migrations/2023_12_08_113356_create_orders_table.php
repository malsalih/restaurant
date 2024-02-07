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
            $table->foreignId('category_id');
            $table->foreignId('menu_item_id');
            $table->integer('price');
            $table->integer('item_count')->default(1);
            $table->foreignId('order_type_id');
            $table->foreignId('desk_id')->nullable();
            $table->foreignId('order_status_id');
            $table->foreignId('prepaired_by')->nullable();
            $table->foreignId('done_by')->nullable();
            $table->string('notes')->nullable();
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
