<?php

use App\Models\Enums\ContactType;
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
        Schema::create('user_contact', function (Blueprint $table) {
            $table->uuid('contact_id')->primary();
            $table->foreignUuid('user_id')
                ->constrained('user', 'user_id')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->enum('type', ContactType::values())->nullable(false);
            $table->string('contact', 255)->nullable(false);
            $table->string('provider', 64)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_contact');
    }
};
