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
            $table->string("do_code");
            $table->double("expected_tonnage");
            $table->double("customer_tonnage")->nullable();
            $table->double("branch_tonnage")->nullable();
            $table->double("main_tonnage")->nullable();
            $table->double("retur_tonnage")->nullable();
            $table->double("arrived_tonnage")->nullable();
            $table->double("tonnage_left")->nullable();
            $table->date("delivery_date")->nullable();
            $table->date("arrival_date")->nullable();
            $table->date("sold_date")->nullable();
            $table->integer("sell_price")->nullable();
            $table->integer("buy_price")->nullable();
            $table->integer("sack")->default(0)->nullable();
            $table->integer("finance_approved")->default(0)->nullable();
            $table->integer("customer_tonnage_sold")->default(0)->nullable();
            $table->integer("is_hold")->default(0)->nullable();
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
