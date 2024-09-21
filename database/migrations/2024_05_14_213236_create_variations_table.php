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
        Schema::create('variation', function (Blueprint $table) {
            $table->uuid('variation_id')->primary();
            $table->string('name')->nullable(false)->unique();
            $table->text('description')->nullable();
            $table->foreignUuid('owner_id')
                ->nullable()
                ->constrained('user', 'user_id')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variation');
    }
};
