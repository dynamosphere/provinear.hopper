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
        // Per User Application Configuration
        Schema::create('user_config', function (Blueprint $table) {
            $table->string('user_config_key')->nullable(false);
            $table->foreignUuid('user_id')
                ->nullable(false)
                ->constrained('user', 'user_id')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->unique(['user_config_key', 'user_id']);
            $table->text('description')->nullable();
            $table->string('value')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_configs');
    }
};
