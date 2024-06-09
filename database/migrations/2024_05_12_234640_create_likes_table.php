<?php

use App\Models\Enums\LikeableObject;
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
        Schema::create('like', function (Blueprint $table) {
            $table->uuid('like_id')->primary();
            $table->uuid('object_id')->nullable(false);
            $table->enum('object_type', LikeableObject::values())->nullable(false);
            $table->boolean('liked')->nullable(false);
            $table->foreignUuid('user_id')
                ->nullable(false)
                ->constrained('user', 'user_id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->unique(['object_id', 'object_type', 'user_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('like');
    }
};
