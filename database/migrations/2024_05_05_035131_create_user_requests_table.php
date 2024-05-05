<?php

use App\Models\Enums\RequestType;
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
        Schema::create('user_request', function (Blueprint $table) {
            $table->uuid('user_request_id')->primary();
            $table->enum('request_type', RequestType::values())->nullable(false);
            $table->text('request')->nullable(false);
            $table->decimal('budget')->nullable();
            $table->string('supporting_image_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_request');
    }
};
