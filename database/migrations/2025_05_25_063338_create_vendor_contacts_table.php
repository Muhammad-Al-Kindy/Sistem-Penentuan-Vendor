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
        Schema::create('vendor_contacts', function (Blueprint $table) {
            $table->id('idVendorContact');
            $table->unsignedBigInteger('vendorId');
            $table->string('contactPerson');
            $table->string('telepon');
            $table->string('fax');
            $table->string('email');
            $table->string('jabatan')->nullable();

            $table->foreign('vendorId')->references('idVendor')->on('vendors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_contacts');
    }
};