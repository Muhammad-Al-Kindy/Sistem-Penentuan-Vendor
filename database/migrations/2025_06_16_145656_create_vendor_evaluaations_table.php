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
        Schema::create('vendor_evaluaations', function (Blueprint $table) {
            $table->id('idVendorEvaluation');
            $table->unsignedBigInteger('vendorId');
            $table->unsignedBigInteger('kriteriaId');
            $table->float('nilai');
            $table->string('periode');
            $table->timestamps();

            $table->foreign('vendorId')->references('idVendor')->on('vendors')->onDelete('cascade');
            $table->foreign('kriteriaId')->references('idKriteria')->on('kriterias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_evaluaations');
    }
};