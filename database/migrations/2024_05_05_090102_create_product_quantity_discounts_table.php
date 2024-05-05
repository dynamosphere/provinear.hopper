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
        Schema::create('product_quantity_discount', function (Blueprint $table) {
            $table->uuid('product_quantity_discount_id')->primary();
            $table->foreignUuid('product_id')
                ->nullable(false)
                ->constrained('product', 'product_id')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->integer('quantity', false, true)->default(0);
            $table->decimal('percentage_discount', 10)->default(0.0);
            $table->boolean('available')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_quantity_discount');
    }
};
