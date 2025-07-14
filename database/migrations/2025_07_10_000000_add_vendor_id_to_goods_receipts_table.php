<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVendorIdToGoodsReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('goods_receipts', function (Blueprint $table) {
            $table->unsignedBigInteger('vendor_id')->nullable()->after('purchaseOrderId');

            $table->foreign('vendor_id')->references('idVendor')->on('vendors')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('goods_receipts', function (Blueprint $table) {
            $table->dropForeign(['vendor_id']);
            $table->dropColumn('vendor_id');
        });
    }
}