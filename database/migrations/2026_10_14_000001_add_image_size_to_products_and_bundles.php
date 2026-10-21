<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedSmallInteger('image_width')->nullable()->after('image');
            $table->unsignedSmallInteger('image_height')->nullable()->after('image_width');
            $table->string('image_fit', 20)->default('cover')->after('image_height');
        });

        Schema::table('bundles', function (Blueprint $table) {
            $table->unsignedSmallInteger('image_width')->nullable()->after('image');
            $table->unsignedSmallInteger('image_height')->nullable()->after('image_width');
            $table->string('image_fit', 20)->default('cover')->after('image_height');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['image_width', 'image_height', 'image_fit']);
        });

        Schema::table('bundles', function (Blueprint $table) {
            $table->dropColumn(['image_width', 'image_height', 'image_fit']);
        });
    }
};
