<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SuccessResource;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LabaRugiController extends Controller
{
    public function get_report(Request $request)
    {
        $month = $request->get('month', Carbon::now()->format('Y-m'));

        if (!preg_match('/^\d{4}-\d{2}$/', $month)) {
            return response()->json([
                'message' => 'Format bulan harus YYYY-MM.',
            ], 422);
        }

        $start = Carbon::parse($month . '-01')->startOfMonth();
        $end = $start->copy()->endOfMonth();
        $previousEnd = $start->copy()->subDay()->endOfDay();

        $stokAwal = $this->stockAt($previousEnd);
        $stokAkhir = $this->stockAt($end);
        $beliBarang = $this->purchasesBetween($start, $end);

        $stokAwalTotal = round($this->sumColumn($stokAwal, 'nominal'), 2);
        $stokAkhirTotal = round($this->sumColumn($stokAkhir, 'nominal'), 2);
        $beliBarangTotal = round($this->sumColumn($beliBarang, 'nominal'), 2);

        $stokAwalTonnage = round($this->sumColumn($stokAwal, 'tonnage'), 2);
        $stokAkhirTonnage = round($this->sumColumn($stokAkhir, 'tonnage'), 2);
        $beliBarangTonnage = round($this->sumColumn($beliBarang, 'tonnage'), 2);

        $salesQuery = DB::table('rit_transactions')
            ->whereNotNull('created_at')
            ->whereBetween('created_at', [$start->toDateTimeString(), $end->toDateTimeString()]);

        $hpp = round($stokAwalTotal + $beliBarangTotal - $stokAkhirTotal, 2);
        $omset = round((float) (clone $salesQuery)->sum('total_price'), 2);
        $omsetTonnage = round((float) (clone $salesQuery)->sum('tonnage'), 2);
        $biaya = round($this->operationalExpense($start, $end), 2);
        $laba = round($omset - $biaya - $hpp, 2);

        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => [
                'month' => $start->format('Y-m'),
                'stok_awal' => [
                    'rows' => $stokAwal,
                    'total' => $stokAwalTotal,
                    'total_tonnage' => $stokAwalTonnage,
                ],
                'stok_akhir' => [
                    'rows' => $stokAkhir,
                    'total' => $stokAkhirTotal,
                    'total_tonnage' => $stokAkhirTonnage,
                ],
                'beli_barang' => [
                    'rows' => $beliBarang,
                    'total' => $beliBarangTotal,
                    'total_tonnage' => $beliBarangTonnage,
                ],
                'hpp' => $hpp,
                'omset' => $omset,
                'omset_tonnage' => $omsetTonnage,
                'biaya' => $biaya,
                'laba' => $laba,
            ],
        ];

        return SuccessResource::make($return);
    }

    /**
     * Latest known remaining tonnage per RIT on or before the cutoff.
     */
    private function stockAt(Carbon $cutoff): array
    {
        $rows = DB::select(
            "
            WITH ranked AS (
                SELECT rr.rit_id, rr.tonnage_left,
                       ROW_NUMBER() OVER (
                           PARTITION BY rr.rit_id
                           ORDER BY rep.created_at DESC, rr.id DESC
                       ) AS rn
                FROM report_rits rr
                JOIN reports rep ON rep.id = rr.report_id
                WHERE rep.created_at <= ?
            )
            SELECT r.id AS rit_id, i.code AS item_code, r.arrival_date, r.buy_price,
                   ranked.tonnage_left,
                   (ranked.tonnage_left * COALESCE(r.buy_price, 0)) AS nominal
            FROM rits r
            JOIN ranked ON ranked.rit_id = r.id AND ranked.rn = 1
            LEFT JOIN items i ON i.id = r.item_id
            WHERE ranked.tonnage_left > 0
            ORDER BY i.code
            ",
            [$cutoff->toDateTimeString()]
        );

        return array_map(function ($row) {
            return [
                'rit_id' => $row->rit_id,
                'item_code' => $row->item_code,
                'arrival_date' => $row->arrival_date,
                'tonnage' => (float) $row->tonnage_left,
                'buy_price' => (float) $row->buy_price,
                'nominal' => (float) $row->nominal,
            ];
        }, $rows);
    }

    /**
     * RITs that arrived in the selected month, valued at their buy price.
     */
    private function purchasesBetween(Carbon $start, Carbon $end): array
    {
        $rows = DB::table('rits')
            ->leftJoin('items', 'items.id', '=', 'rits.item_id')
            ->whereBetween('rits.arrival_date', [$start->toDateString(), $end->toDateString()])
            ->whereNotNull('rits.arrived_tonnage')
            ->where('rits.arrived_tonnage', '>', 0)
            ->orderBy('rits.arrival_date')
            ->get([
                'rits.id as rit_id',
                'items.code as item_code',
                'rits.arrival_date',
                'rits.arrived_tonnage',
                'rits.buy_price',
                DB::raw('(rits.arrived_tonnage * COALESCE(rits.buy_price, 0)) as nominal'),
            ]);

        return $rows->map(function ($row) {
            return [
                'rit_id' => $row->rit_id,
                'item_code' => $row->item_code,
                'arrival_date' => $row->arrival_date,
                'tonnage' => (float) $row->arrived_tonnage,
                'buy_price' => (float) $row->buy_price,
                'nominal' => (float) $row->nominal,
            ];
        })->all();
    }

    /**
     * Same definition used by the existing Laba Rugi screen.
     */
    private function operationalExpense(Carbon $start, Carbon $end): float
    {
        $expenses = Expense::with('trip')
            ->whereBetween('time', [$start->toDateTimeString(), $end->toDateTimeString()])
            ->get();

        $total = 0;

        foreach ($expenses as $expense) {
            if (!in_array($expense->type, ['Kendaraan', 'Operasional', 'Gaji'])) {
                continue;
            }

            if ($expense->type === 'Kendaraan') {
                if ($expense->trip) {
                    $total += (float) $expense->trip->gas
                        + (float) $expense->trip->toll
                        + (float) $expense->trip->allowance;
                }
            } else {
                $total += (float) $expense->amount;
            }
        }

        return $total;
    }

    private function sumColumn(array $rows, string $column): float
    {
        return array_sum(array_column($rows, $column));
    }
}
