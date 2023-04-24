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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->integer("allowance")->default(0);
            $table->integer("toll")->default(0);
            $table->integer("gas")->default(0);
            $table->text("note")->nullable();
            $table->integer("toll_used")->default(0);
            $table->integer("branch_to_main_tonnage")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
