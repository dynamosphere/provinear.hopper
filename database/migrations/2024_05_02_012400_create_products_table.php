<?php

use App\Models\Enums\ProductApprovalStatus;
use App\Models\Enums\ProductStatus;
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
        Schema::create('product', function (Blueprint $table) {
            $table->uuid('product_id')->primary();
            $table->foreignUuid('shop_id')
                ->nullable(false)
                ->constrained('shop', 'shop_id')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->string('product_name')->nullable(false);
            $table->text('product_description');
            $table->string('brand_name')->nullable();
            $table->json('product_attribute')->nullable();
            $table->enum('product_status', ProductStatus::values())->default(ProductStatus::AVAILABLE);
            $table->integer('available_quantity', false, true)->nullable();
            $table->decimal('unit_price', 10)->nullable(false);
            $table->foreignId('currency_code')
                ->nullable(false)
                ->default('NGN')
                ->constrained('currency', 'iso_code', 'product_currency_fk')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->decimal('strikeout_price', 10)->nullable();
            $table->string('unit_measure')->nullable();
            $table->decimal('price_percentage_discount', 10)->default(0.00);
            $table->enum('approval_status', ProductApprovalStatus::values())->default(ProductApprovalStatus::PENDING);
            $table->json('approved_by')->nullable();
            $table->text('approval_comment')->nullable();
            $table->boolean('opened_to_bargain')->default(false);
            $table->integer('estimated_prepare_minute', false, true)->default(0);
            $table->unique(['shop_id', 'product_name', 'brand_name'], 'unique_product_constraint');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
