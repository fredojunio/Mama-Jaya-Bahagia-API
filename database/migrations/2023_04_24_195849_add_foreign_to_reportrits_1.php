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
        Schema::table('report_rits', function (Blueprint $table) {
            $table->unsignedBigInteger('rit_id')->index();
            $table->foreign('rit_id')->references('id')->on('rits')->onDelete('cascade');
            $table->unsignedBigInteger('report_id')->index()->nullable();
            $table->foreign('report_id')->references('id')->on('reports')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reportrits', function (Blueprint $table) {
            //
        });
    }
};
