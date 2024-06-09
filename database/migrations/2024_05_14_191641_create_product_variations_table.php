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
        Schema::create('product_variation', function (Blueprint $table) {
            $table->uuid('product_variation_id')->primary();
            $table->foreignUuid('product_id')
                ->nullable(false)
                ->constrained('product', 'product_id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignUuid('variation_id')
                ->nullable(false)
                ->constrained('variation', 'variation_id')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->string('variation_value')->nullable(false);
            $table->unique(['product_id', 'variation_id', 'variation_value']);
            $table->decimal('variation_price', 10)->nullable();
            $table->json('variation_detail')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variation');
    }
};
