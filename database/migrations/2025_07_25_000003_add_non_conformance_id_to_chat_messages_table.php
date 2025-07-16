<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNonConformanceIdToChatMessagesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('chat_messages', function (Blueprint $table) {
            $table->unsignedBigInteger('non_conformance_id')->nullable()->after('to_id');

            $table->foreign('non_conformance_id')->references('idNonConformance')->on('non_conformances')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chat_messages', function (Blueprint $table) {
            $table->dropForeign(['non_conformance_id']);
            $table->dropColumn('non_conformance_id');
        });
    }
}
