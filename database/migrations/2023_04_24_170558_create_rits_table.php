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
        Schema::create('rits', function (Blueprint $table) {
            $table->id();
            $table->integer("expected_tonnage");
            $table->integer("customer_tonnage")->nullable();
            $table->integer("branch_tonnage")->nullable();
            $table->integer("main_tonnage")->nullable();
            $table->integer("retur_tonnage")->nullable();
            $table->integer("arrived_tonnage")->nullable();
            $table->integer("tonnage_left")->nullable();
            $table->date("delivery_date")->nullable();
            $table->date("arrival_date")->nullable();
            $table->date("sold_date")->nullable();
            $table->integer("sell_price")->nullable();
            $table->integer("buy_price")->nullable();
            $table->integer("sack")->default(0);
            $table->integer("finance_approved")->default(0);
            $table->integer("customer_tonnage_sold")->default(0);
            $table->integer("is_hold")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rits');
    }
};
