<?php

use App\Models\Enums\TaggableObject;
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
        Schema::create('object_tag', function (Blueprint $table) {
            $table->uuid('object_id')->nullable(false);
            $table->foreignUuid('tag_id')
                ->nullable(false)
                ->constrained('tag', 'tag_id')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->enum('object_type', TaggableObject::values());
            $table->unique(['object_id', 'tag_id', 'object_type']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('object_tag');
    }
};
