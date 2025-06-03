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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2); // Stores up to 99999999.99
            $table->integer('stock')->nullable();
            $table->string('image')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();

            // Correct foreign key constraint
            $table->foreign('category_id')
                ->references('id') // Correct reference to category 'id'
                ->on('categories')
                ->onDelete('set null'); // Set null when category is deleted

            $table->timestamps();
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
