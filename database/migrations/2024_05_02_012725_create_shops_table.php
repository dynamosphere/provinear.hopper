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
        Schema::create('shop', function (Blueprint $table) {
            $table->uuid('shop_id')->primary();
            $table->foreignUuid('provider_id')
                ->nullable(false)
                ->constrained('provider', 'provider_id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('shop_name', 512)->nullable(false);
            $table->text('shop_description');
            $table->text('address');
            $table->string('brand_logo_url')->nullable();
            $table->string('brand_cover_image_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop');
    }
};
