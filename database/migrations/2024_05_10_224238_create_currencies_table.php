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
        Schema::create('currency', function (Blueprint $table) {
            $table->string('iso_code', 4)->primary();
            $table->string('currency_name');
            $table->string('basic_unit')->nullable(false);
            $table->string('symbol')->nullable(false);
            $table->string('fractional_unit')->nullable();
            $table->unsignedInteger('fractional_to_basic_rate')->nullable();
            $table->foreignUuid('admin_id')
                ->nullable()
                ->constrained('admin', 'admin_id')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->timestamps();
        });

        DB::table('currency')->insert([
            'iso_code' => 'NGN',
            'currency_name' => 'Nigeria Naira',
            'symbol' => '₦',
            'basic_unit' => 'naira',
            'fractional_unit' => 'kobo',
            'fractional_to_basic_rate' => 100
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currency');
    }
};
