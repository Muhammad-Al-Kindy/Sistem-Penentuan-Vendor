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
        Schema::create('goods_receipts_items', function (Blueprint $table) {
            $table->id('idGoodReceiptsItem');
            $table->unsignedBigInteger('goodsReceiptId');
            $table->unsignedBigInteger('materialId');
            $table->string('deskripsi');
            $table->string('satuan');
            $table->integer('qty_po');
            $table->integer('qty_diterima');
            $table->string('ncr')->nullable();
            $table->string('lokasi_gudang')->nullable();
            $table->timestamps();

            $table->foreign('goodsReceiptId')->references('idGoodsReceipt')->on('goods_receipts')->onDelete('cascade');
            $table->foreign('materialId')->references('idMaterial')->on('materials')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goods_receipts_items');
    }
};
