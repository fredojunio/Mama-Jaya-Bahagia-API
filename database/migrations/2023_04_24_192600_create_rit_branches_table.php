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
        Schema::create('rit_branches', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->integer("sent_tonnage");
            $table->integer("income")->nullable();
            $table->date("delivery_date");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rit_branches');
    }
};
