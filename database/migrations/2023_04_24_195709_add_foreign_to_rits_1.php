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
        Schema::table('rits', function (Blueprint $table) {
            $table->unsignedBigInteger('item_id')->index()->nullable();
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            $table->unsignedBigInteger('trip_id')->index()->nullable();
            $table->foreign('trip_id')->references('id')->on('trips')->onDelete('cascade');
            $table->unsignedBigInteger('retur_trip_id')->index()->nullable();
            $table->foreign('retur_trip_id')->references('id')->on('trips')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rits', function (Blueprint $table) {
            //
        });
    }
};
