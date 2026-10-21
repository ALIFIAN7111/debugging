<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bundles', function (Blueprint $table) {
            $table->string('image_fit', 20)->default('cover')->after('image');
            $table->string('image_ratio', 20)->default('16/9')->after('image_fit');
            $table->string('image_position', 20)->default('center')->after('image_ratio');
        });
    }

    public function down(): void
    {
        Schema::table('bundles', function (Blueprint $table) {
            $table->dropColumn(['image_fit', 'image_ratio', 'image_position']);
        });
    }
};
