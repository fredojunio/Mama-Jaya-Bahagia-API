<?php

use Carbon\Carbon;
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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->integer("amount");
            $table->text("note")->nullable();
            $table->string("name")->nullable();
            $table->dateTime("time")->default(Carbon::now());
            $table->string("type");
            $table->unsignedBigInteger('trip_id')->index()->nullable();
            $table->foreign('trip_id')->references('id')->on('trips')->onDelete('cascade');
            $table->unsignedBigInteger('saving_id')->index()->nullable();
            $table->foreign('saving_id')->references('id')->on('savings')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
