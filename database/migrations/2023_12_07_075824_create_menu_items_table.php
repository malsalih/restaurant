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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
          // $table->foreignId('chef_id');
            $table->foreignId('category_id');
            $table->integer('price');
            $table->integer('discounted_price')->nullable();
            $table->string('image')->nullable();
            $table->string('details');
            $table->boolean('available');
            $table->integer('prep_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
