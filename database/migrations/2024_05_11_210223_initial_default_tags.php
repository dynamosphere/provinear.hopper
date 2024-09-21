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
        DB::table('tag')->insert(
            [
                'tag_id'    => 'main_image',
                'tag_name'  => 'MAIN_IMAGE',
                'tag_description'   => 'Main image of a product'
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('tag')->delete('main_image');
    }
};
