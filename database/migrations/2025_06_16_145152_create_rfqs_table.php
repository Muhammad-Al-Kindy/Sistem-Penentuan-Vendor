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
        Schema::create('rfqs', function (Blueprint $table) {
            $table->id('idrfqs');
            $table->unsignedBigInteger('purchaseOrderId');
            $table->string('no_rfq')->nullable();
            $table->string('rfq_collective')->nullable();
            $table->string('referensi_sph')->nullable();
            $table->string('no_justifikasi')->nullable();
            $table->string('no_negosiasi')->nullable();
            $table->timestamps();

            $table->foreign('purchaseOrderId')->references('idPurchaseOrder')->on('purchase_orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rfqs');
    }
};