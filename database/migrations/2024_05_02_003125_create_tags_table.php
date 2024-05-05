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
        Schema::create('tag', function (Blueprint $table) {
            $table->uuid('tag_id')->primary();
            $table->string('tag_name',64)->nullable(false)->unique();
            $table->text('tag_description')->nullable();
            $table->foreignUuid('owner_id')
                ->nullable()
                ->constrained('user', 'user_id')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->boolean('internal')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tag');
    }
};
