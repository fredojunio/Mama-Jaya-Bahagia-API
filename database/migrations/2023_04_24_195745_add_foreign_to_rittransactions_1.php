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
        Schema::table('rit_transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('rit_id')->index()->nullable();
            $table->foreign('rit_id')->references('id')->on('rits')->onDelete('cascade');
            $table->unsignedBigInteger('transaction_id')->index()->nullable();
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rittransactions', function (Blueprint $table) {
            //
        });
    }
};
