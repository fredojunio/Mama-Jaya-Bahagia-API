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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->integer("money")->default(0);
            $table->integer("income")->default(0);
            $table->integer("expense")->default(0);
            $table->double("tonnage")->default(0);
            $table->integer("item_income")->default(0);
            $table->integer("tb_income")->default(0);
            $table->integer("tw_income")->default(0);
            $table->integer("thr_income")->default(0);
            $table->integer("tb_expense")->default(0);
            $table->integer("tw_expense")->default(0);
            $table->integer("thr_expense")->default(0);
            $table->integer("salary_expense")->default(0);
            $table->integer("operational_expense")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
