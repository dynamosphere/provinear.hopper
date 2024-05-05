<?php

use App\Models\Enums\RateableObject;
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
        Schema::create('rating', function (Blueprint $table) {
            $table->uuid('rating_id')->primary();
            $table->uuid('object_id')->nullable(false);
            $table->enum('object_type', RateableObject::values());
            $table->text('comment');
            $table->integer('helpful_upvote_count', false, true);
            $table->integer('helpful_downvote_count', false, true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rating');
    }
};
