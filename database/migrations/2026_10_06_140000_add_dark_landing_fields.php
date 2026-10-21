<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('rating', 2, 1)->default(5.0)->after('is_available');
            $table->unsignedTinyInteger('spice_level')->default(0)->after('rating');
            $table->boolean('is_best_seller')->default(false)->after('spice_level');
        });

        Schema::table('bundles', function (Blueprint $table) {
            $table->decimal('original_price', 15, 2)->nullable()->after('price');
            $table->string('badge', 50)->nullable()->after('original_price');
            $table->boolean('is_popular')->default(false)->after('is_active');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->string('item_type', 20)->default('product')->after('product_id');
            $table->text('options')->nullable()->after('subtotal');
        });

        // product_id nullable agar baris bundle/custom tersimpan.
        // Lintas DB: MySQL pakai MODIFY, SQLite/Postgres lewati (kolom baru sudah nullable via recreate).
        // Catatan: migrasi awal order_items masih NOT NULL, SQLite test perlu nullable manual.
        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE `order_items` MODIFY `product_id` BIGINT UNSIGNED NULL');
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE `order_items` MODIFY `product_id` BIGINT UNSIGNED NOT NULL');
        }

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn(['item_type', 'options']);
        });

        Schema::table('bundles', function (Blueprint $table) {
            $table->dropColumn(['original_price', 'badge', 'is_popular']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['rating', 'spice_level', 'is_best_seller']);
        });
    }
};
