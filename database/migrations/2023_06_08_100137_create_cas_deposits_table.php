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
        Schema::create('cas_deposits', function (Blueprint $table) {
            $table->id();
            $table->integer("koin")->nullable();
            $table->integer("seribu")->nullable();
            $table->integer("duaribu")->nullable();
            $table->integer("limaribu")->nullable();
            $table->integer("sepuluhribu")->nullable();
            $table->integer("duapuluhribu")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cas_deposits');
    }
};
