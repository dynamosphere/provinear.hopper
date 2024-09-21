<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->foreignUuid('admin_id')
                ->primary()
                ->constrained('user', 'user_id');
            $table->foreignUuid('added_by')
                ->nullable()
                ->constrained('admin', 'admin_id')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->timestamps();
        });

        // Create a default System User
        DB::table('user')->insert([
            'user_id'       => 'system',
            'first_name'    => 'System',
            'last_name'     => 'System',
            'email'         => 'system@provinear.com',
            'password'      => 'NO PASSWORD',
            'is_active'     => false,
        ]);
        DB::table('admin')->insert([
            'admin_id'  => 'system'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin');
    }
};
