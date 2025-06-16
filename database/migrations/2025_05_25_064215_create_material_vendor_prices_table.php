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
        Schema::create('material_vendor_prices', function (Blueprint $table) {
            $table->id('idMaterialVendorPrice');
            $table->unsignedBigInteger('materialId');
            $table->unsignedBigInteger('vendorId');
            $table->decimal('harga', 15, 2);
            $table->string('mataUang');

            $table->foreign('materialId')->references('idMaterial')->on('materials')->onDelete('cascade');
            $table->foreign('vendorId')->references('idVendor')->on('vendors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_vendor_prices');
    }
};
