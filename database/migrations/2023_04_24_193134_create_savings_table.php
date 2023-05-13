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
        Schema::create('savings', function (Blueprint $table) {
            $table->id();
            $table->integer("tb")->default(0);
            $table->integer("tw")->default(0);
            $table->integer("thr")->default(0);
            $table->double("tonnage")->default(0);
            $table->integer("total_tw")->default(0);
            $table->integer("total_tb")->default(0);
            $table->integer("total_thr")->default(0);
            $table->double("total_tonnage")->default(0);
            $table->string("type");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('savings');
    }
};
