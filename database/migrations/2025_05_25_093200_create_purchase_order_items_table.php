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
        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->id('idPurchaseOrderItem');
            $table->unsignedBigInteger('purchaseOrderId');
            $table->unsignedBigInteger('materialId');
            $table->unsignedBigInteger('materialVendorPriceId');
            $table->integer('kuantitas');
            $table->decimal('hargaPerUnit', 15, 2);
            $table->string('mataUang');
            $table->integer('vat');
            $table->date('batasDiterima');
            $table->decimal('total', 15, 2);
            $table->timestamps();

            $table->foreign('purchaseOrderId')->references('idPurchaseOrder')->on('purchase_orders')->onDelete('cascade');
            $table->foreign('materialId')->references('idMaterial')->on('materials')->onDelete('cascade');
            $table->foreign('materialVendorPriceId')->references('idMaterialVendorPrice')->on('material_vendor_prices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_order_items');
    }
};