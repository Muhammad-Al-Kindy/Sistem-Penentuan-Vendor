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
            $table->string('no_rfq');
            $table->string('rfq_collective');
            $table->string('referensi_sph');
            $table->string('no_justifikasi');
            $table->string('no_negosiasi');
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