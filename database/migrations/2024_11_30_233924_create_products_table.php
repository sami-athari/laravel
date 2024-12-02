<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name'); // Product name
            $table->text('description')->nullable(); // Product description (optional)
            $table->decimal('price', 10, 2); // Product price
            $table->string('image')->nullable(); // Product image (optional)
            $table->integer('stock')->default(0); // Product stock with default value of 0
            $table->timestamps(); // Timestamps for created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
