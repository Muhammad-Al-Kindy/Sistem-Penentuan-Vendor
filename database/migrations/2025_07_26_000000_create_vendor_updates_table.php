<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorUpdatesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vendor_updates', function (Blueprint $table) {
            $table->id('vendor_update_id');
            $table->unsignedBigInteger('purchase_order_id');
            $table->unsignedBigInteger('vendor_id');
            $table->date('tanggal_update');
            $table->string('jenis_update');
            $table->string('dokumen')->nullable();
            $table->timestamps();

            // Add foreign keys if needed
            $table->foreign('purchase_order_id')->references('idPurchaseOrder')->on('purchase_orders')->onDelete('cascade');
            $table->foreign('vendor_id')->references('idVendor')->on('vendors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_updates');
    }
}