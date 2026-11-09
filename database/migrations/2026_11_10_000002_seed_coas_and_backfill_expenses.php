<?php

use App\Models\Coa;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Coa::upsertDefaults();

        $map = [
            'Kendaraan' => Coa::KENDARAAN,
            'Gaji' => Coa::GAJI,
            'Operasional' => Coa::OPERASIONAL,
        ];

        foreach ($map as $type => $code) {
            $coaId = DB::table('coas')->where('code', $code)->value('id');

            if ($coaId) {
                DB::table('expenses')
                    ->where('type', $type)
                    ->whereNull('coa_id')
                    ->update(['coa_id' => $coaId]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $codes = array_column(Coa::defaultData(), 'code');
        $ids = DB::table('coas')->whereIn('code', $codes)->pluck('id');

        DB::table('expenses')->whereIn('coa_id', $ids)->update(['coa_id' => null]);
        DB::table('coas')->whereIn('code', $codes)->delete();
    }
};
