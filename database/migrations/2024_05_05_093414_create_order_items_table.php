<?php

use App\Models\Enums\OrderStatus;
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
        Schema::create('order_item', function (Blueprint $table) {
            $table->uuid('order_item_id')->primary();
            $table->foreignUuid('order_id')
                ->nullable(false)
                ->constrained('product_order', 'order_id')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->foreignUuid('product_id')
                ->nullable(false)
                ->constrained('product', 'product_id')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->integer('quantity', false, true)->default(1);
            $table->enum('status', OrderStatus::values())->default(OrderStatus::PENDING);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_item');
    }
};
