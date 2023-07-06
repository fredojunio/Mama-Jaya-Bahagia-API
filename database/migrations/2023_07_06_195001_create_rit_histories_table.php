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
        Schema::create('rit_histories', function (Blueprint $table) {
            $table->id();
            $table->text("info");
            $table->unsignedBigInteger('rit_id')->index();
            $table->foreign('rit_id')->references('id')->on('rits')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rit_histories');
    }
};
