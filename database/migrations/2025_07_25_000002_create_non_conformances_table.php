<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNonConformancesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('non_conformances', function (Blueprint $table) {
            $table->id('idNonConformance');
            $table->unsignedBigInteger('goods_receipt_item_id');
            $table->dateTime('tanggal_ditemukan');
            $table->dateTime('tanggal_respon_vendor')->nullable();
            $table->enum('status', ['open', 'responded', 'closed'])->default('open');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('goods_receipt_item_id')->references('idGoodReceiptsItem')->on('goods_receipts_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('non_conformances');
    }
}
