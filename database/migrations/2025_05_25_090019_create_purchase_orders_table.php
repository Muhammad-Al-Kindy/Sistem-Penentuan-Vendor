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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id('idPurchaseOrder');
            $table->unsignedBigInteger('vendorId');
            $table->string('noPO');
            $table->date('tanggalPO');
            $table->string('noKontrak')->nullable();
            $table->string('noRevisi')->nullable();
            $table->date('tanggalRevisi')->nullable();
            $table->string('incoterm')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('vendorId')->references('idVendor')->on('vendors')->onDelete('cascade');
            $table->foreign('created_by')->references('idUser')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};