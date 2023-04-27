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
        Schema::create('rit_transactions', function (Blueprint $table) {
            $table->id();
            $table->integer("tonnage");
            $table->integer("masak")->default(1);
            $table->integer("item_price");
            $table->integer("total_price");
            $table->integer("tonnage_left")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rit_transactions');
    }
};
