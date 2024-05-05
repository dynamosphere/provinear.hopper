<?php

use App\Models\Enums\TransactionStatus;
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
        Schema::create('transaction', function (Blueprint $table) {
            $table->uuid('transaction_id')->primary();
            $table->foreignUuid('order_id')
                ->nullable(false)
                ->unique()
                ->constrained('product_order', 'order_id')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->decimal('amount', 10)->nullable(false);
            $table->string('payment_method')->nullable('false');
            $table->json('payment_detail');
            $table->enum('status', TransactionStatus::values())->default(TransactionStatus::PENDING);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction');
    }
};
