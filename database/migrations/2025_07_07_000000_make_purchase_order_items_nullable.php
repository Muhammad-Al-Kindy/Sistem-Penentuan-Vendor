<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakePurchaseOrderItemsNullable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('purchase_order_items', function (Blueprint $table) {
            $table->decimal('hargaPerUnit', 15, 2)->nullable()->change();
            $table->string('mataUang')->nullable()->change();
            $table->decimal('total', 15, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_order_items', function (Blueprint $table) {
            $table->decimal('hargaPerUnit', 15, 2)->nullable(false)->change();
            $table->string('mataUang')->nullable(false)->change();
            $table->decimal('total', 15, 2)->nullable(false)->change();
        });
    }
}