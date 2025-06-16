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
        Schema::create('goods_receipts', function (Blueprint $table) {
            $table->id('idGoodsReceipt');
            $table->string('no_dokumen');
            $table->date('tanggal_dok');
            $table->date('tanggal_terima');
            $table->unsignedBigInteger('purchaseOrderId');
            $table->string('no_surat_jalan');
            $table->string('proyek')->nullable();
            $table->string('halaman')->nullable();
            $table->timestamps();

            $table->foreign('purchaseOrderId')->references('idPurchaseOrder')->on('purchase_orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goods_receipts');
    }
};
