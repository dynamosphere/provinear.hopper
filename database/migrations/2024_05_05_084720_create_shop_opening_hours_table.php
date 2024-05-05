<?php

use App\Models\Enums\WeekDay;
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
        Schema::create('shop_opening_hour', function (Blueprint $table) {
            $table->uuid('shop_opening_hour_id');
            $table->foreignUuid('shop_id')
                ->nullable(false)
                ->constrained('shop', 'shop_id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->enum('day', WeekDay::values())->nullable(false);
            $table->time('opening_time')->default('09:00:00');
            $table->time('closing_time')->default('17:00:00');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_opening_hour');
    }
};
