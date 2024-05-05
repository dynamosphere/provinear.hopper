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
        Schema::create('provider', function (Blueprint $table) {
            $table->uuid('provider_id')->primary();
            $table->foreignUuid( 'user_id')
                ->unique()
                ->nullable(false)
                ->constrained('user', 'user_id')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->string('portrait_url')->nullable();
            $table->string('badge')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provider');
    }
};
