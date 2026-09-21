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
        Schema::table('cas', function (Blueprint $table) {
            $table->integer('transfer')->nullable()->default(0)->after('duapuluhribu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cas', function (Blueprint $table) {
            $table->dropColumn('transfer');
        });
    }
};
