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
        Schema::create('user_kyc', function (Blueprint $table) {
            $table->uuid('kcy_registration_id')->primary();
            $table->string('first_name')->nullable(false);
            $table->string('last_name')->nullable(false);
            $table->date('date_of_birth')->nullable(false);
            $table->text('address')->nullable(false);
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable(false);
            $table->foreignUuid('user_id')
                ->unique()
                ->constrained('user', 'user_id', 'user_kyc_registration_fk')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignUuid('verification_option_id')
                ->constrained('kyc_verification_option', 'verification_option_id')
                ->restrictOnDelete()
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_kyc');
    }
};
