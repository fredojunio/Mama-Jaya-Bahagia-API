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
        Schema::create('report_transactions', function (Blueprint $table) {
            $table->id();
            $table->integer("amount");
            $table->date("transaction_date");
            $table->date("settled_date")->nullable();
            $table->unsignedBigInteger('transaction_id')->index();
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
            $table->unsignedBigInteger('report_id')->index();
            $table->foreign('report_id')->references('id')->on('reports')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_transactions');
    }
};
