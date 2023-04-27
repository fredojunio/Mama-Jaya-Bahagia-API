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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->integer("daily_id");
            $table->integer("tb")->default(0);
            $table->integer("tw")->default(0);
            $table->integer("thr")->default(0);
            $table->integer("sack")->default(0);
            $table->integer("sack_price")->default(0);
            $table->integer("item_price")->nullable();
            $table->integer("discount")->default(0);
            $table->integer("ongkir")->default(0);
            $table->integer("total_price");
            $table->date("settled_date")->nullable();
            $table->integer("owner_approved")->default(0);
            $table->integer("finance_approved")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
