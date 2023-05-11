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
        Schema::create('customers',function (Blueprint $table) {
            $table->id();
            $table->string('nik');
            $table->string('name');
            $table->string('nickname');
            $table->string('address');
            $table->string('hp')->nullable();
            $table->integer('ongkir')->default(0);
            $table->date('birthdate');
            $table->string('type');
            $table->integer("tb")->default(0);
            $table->integer("tw")->default(0);
            $table->integer("thr")->default(0);
            $table->integer("tonnage")->default(0);
            $table->integer("cashback_approved")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
