<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('unit', 30)->default('pcs');
            $table->decimal('stock', 12, 2)->default(0);
            $table->decimal('minimum_stock', 12, 2)->default(0);
            $table->decimal('unit_cost', 15, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('production_stocks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('quantity', 12, 2)->default(0);
            $table->string('unit', 30)->default('pcs');
            $table->date('production_date');
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique();
            $table->string('customer_name')->nullable();
            $table->decimal('total', 15, 2)->default(0);
            $table->string('payment_method', 50)->default('Tunai');
            $table->string('status', 30)->default('Selesai');
            $table->timestamps();
        });

        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category', 50)->default('Operasional');
            $table->decimal('amount', 15, 2);
            $table->date('spent_at');
            $table->timestamps();
        });

        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('bundles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 15, 2);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('admin_notes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->date('note_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_notes');
        Schema::dropIfExists('bundles');
        Schema::dropIfExists('payment_methods');
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('production_stocks');
        Schema::dropIfExists('ingredients');
    }
};
