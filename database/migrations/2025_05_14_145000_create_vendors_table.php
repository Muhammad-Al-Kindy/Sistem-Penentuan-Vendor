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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id('idVendor');
            $table->string('namaVendor');
            $table->string('alamatVendor');
            $table->string('NPWP');
            $table->string('SPPKP');
            $table->string('nomorIndukPerusahaan');
            $table->string('jenisPerusahaan');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};