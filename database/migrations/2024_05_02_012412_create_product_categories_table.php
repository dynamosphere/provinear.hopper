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
        Schema::create('product_category', function (Blueprint $table) {
            $table->foreignUuid('category_id')
                ->nullable(false)
                ->constrained('category', 'category_id')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->foreignUuid('product_id')
                ->nullable(false)
                ->constrained('product', 'product_id')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->unique(['category_id', 'product_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_category');
    }
};
