<?php

use App\Models\Shop;
use App\Models\UserContact;
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
        Schema::create('shop_provider_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Shop::class, 'shop')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(UserContact::class, 'contact')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_provider_contacts');
    }
};
