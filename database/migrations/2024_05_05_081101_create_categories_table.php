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
        Schema::create('category', function (Blueprint $table) {
            $table->uuid('category_id')->primary();
            $table->string('category_name')->nullable(false)->unique();
            $table->text('category_description')->nullable();
            $table->foreignUuid('parent_id')
                ->nullable()
                ->constrained('category', 'category_id')
                ->cascadeOnUpdate()
                ->nullOnDelete();
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
        Schema::dropIfExists('category');
    }
};
