<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateVendorEvaluationsStructure extends Migration
{
    public function up(): void
    {
        Schema::table('vendor_evaluaations', function (Blueprint $table) {
            // Tambahkan kolom hanya jika belum ada
            if (!Schema::hasColumn('vendor_evaluaations', 'material_id')) {
                $table->unsignedBigInteger('material_id')->nullable()->after('vendorId');
                $table->foreign('material_id')->references('idMaterial')->on('materials')->onDelete('set null');
            }

            if (!Schema::hasColumn('vendor_evaluaations', 'purchase_order_id')) {
                $table->unsignedBigInteger('purchase_order_id')->nullable()->after('material_id');
                $table->foreign('purchase_order_id')->references('idPurchaseOrder')->on('purchase_orders')->onDelete('set null');
            }

            if (!Schema::hasColumn('vendor_evaluaations', 'delivery_score')) {
                $table->float('delivery_score')->default(0)->after('purchase_order_id');
                $table->float('monitoring_score')->default(0);
                $table->float('quality_score')->default(0);
                $table->float('respon_nc_score')->default(0);
                $table->float('po_batal_score')->default(0);
            }

            if (!Schema::hasColumn('vendor_evaluaations', 'tanggal_evaluasi')) {
                $table->date('tanggal_evaluasi')->nullable()->after('po_batal_score');
            }

            // Hapus kolom lama jika ada
            if (Schema::hasColumn('vendor_evaluaations', 'kriteriaId')) {
                $table->dropForeign(['kriteriaId']);
                $table->dropColumn('kriteriaId');
            }
            if (Schema::hasColumn('vendor_evaluaations', 'nilai')) {
                $table->dropColumn('nilai');
            }
            if (Schema::hasColumn('vendor_evaluaations', 'periode')) {
                $table->dropColumn('periode');
            }
        });
    }

    public function down(): void
    {
        Schema::table('vendor_evaluaations', function (Blueprint $table) {
            // Tambahkan kembali kolom lama
            if (!Schema::hasColumn('vendor_evaluaations', 'kriteriaId')) {
                $table->unsignedBigInteger('kriteriaId')->nullable();
            }
            if (!Schema::hasColumn('vendor_evaluaations', 'nilai')) {
                $table->float('nilai')->nullable();
            }
            if (!Schema::hasColumn('vendor_evaluaations', 'periode')) {
                $table->string('periode')->nullable();
            }

            // Hapus kolom baru jika ada
            if (Schema::hasColumn('vendor_evaluaations', 'material_id')) {
                $table->dropForeign(['material_id']);
                $table->dropColumn('material_id');
            }

            if (Schema::hasColumn('vendor_evaluaations', 'purchase_order_id')) {
                $table->dropForeign(['purchase_order_id']);
                $table->dropColumn('purchase_order_id');
            }

            foreach (
                [
                    'delivery_score',
                    'monitoring_score',
                    'quality_score',
                    'respon_nc_score',
                    'po_batal_score',
                    'tanggal_evaluasi'
                ] as $col
            ) {
                if (Schema::hasColumn('vendor_evaluaations', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
}