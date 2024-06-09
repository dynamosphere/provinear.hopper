<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // System-wide Application Configuration
        Schema::create('app_config', function (Blueprint $table) {
            $table->uuid('app_config_key')->primary();
            $table->string('value')->nullable();
            $table->text('description')->nullable();
            $table->boolean('internal')->default(true); // Configuration value is to be used internally, not opened to public
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_config');
    }
};
