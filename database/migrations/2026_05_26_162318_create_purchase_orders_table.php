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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('po_code')->unique();
            $table->unsignedBigInteger('item_id');
            $table->double('tonnage');
            $table->double('buy_price');
            $table->enum('status', ['pending', 'completed'])->default('pending');
            $table->timestamps();
            
            $table->foreign('item_id')->references('id')->on('items')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
