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
        Schema::create('product_order', function (Blueprint $table) {
            $table->uuid('order_id')->primary();
            $table->foreignUuid('user_id')
                ->nullable(false)
                ->constrained('user', 'user_id')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->string('reference_number')->nullable()->unique();
            $table->enum('status', OrderStatus::values())->default(OrderStatus::PENDING);
            $table->json('fulfilled_by')->nullable();
            $table->dateTime('date_fulfilled')->nullable();
            $table->foreignUuid('billing_address_id')
                ->nullable(false)
                ->constrained('billing_address', 'billing_address_id')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_order');
    }
};
