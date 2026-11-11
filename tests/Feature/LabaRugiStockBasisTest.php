<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Passport;
use Tests\TestCase;

class LabaRugiStockBasisTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        Passport::actingAs(User::first());
    }

    public function test_a_lower_physical_count_values_stock_at_the_physical_tonnage(): void
    {
        $before = $this->report('2035-03');

        $ritId = $this->rit('TEST-FISIK-LOWER', 1000);
        $this->snapshot('2035-03-20 10:00:00', $ritId, 25, 20);

        $after = $this->report('2035-03');

        $this->assertEqualsWithDelta(
            20.0,
            $after['stok_akhir']['total_tonnage'] - $before['stok_akhir']['total_tonnage'],
            0.001
        );
        $this->assertEqualsWithDelta(
            20000.0,
            $after['stok_akhir']['total'] - $before['stok_akhir']['total'],
            0.01
        );

        $row = $this->row($after['stok_akhir']['rows'], $ritId);

        $this->assertSame('fisik', $row['basis']);
        $this->assertEqualsWithDelta(25.0, $row['tonnage_sistem'], 0.001);
        $this->assertEqualsWithDelta(20.0, $row['tonnage_fisik'], 0.001);
        $this->assertEqualsWithDelta(-5.0, $row['selisih'], 0.001);
        $this->assertEqualsWithDelta(20.0, $row['tonnage'], 0.001);
        $this->assertEqualsWithDelta(20000.0, $row['nominal'], 0.01);
    }

    public function test_a_higher_physical_count_is_ignored_for_valuation(): void
    {
        $before = $this->report('2035-03');

        $ritId = $this->rit('TEST-FISIK-HIGHER', 1000);
        $this->snapshot('2035-03-20 10:00:00', $ritId, 25, 30);

        $after = $this->report('2035-03');

        $this->assertEqualsWithDelta(
            25.0,
            $after['stok_akhir']['total_tonnage'] - $before['stok_akhir']['total_tonnage'],
            0.001
        );

        $row = $this->row($after['stok_akhir']['rows'], $ritId);

        $this->assertSame('sistem', $row['basis']);
        $this->assertEqualsWithDelta(5.0, $row['selisih'], 0.001);
        $this->assertEqualsWithDelta(25.0, $row['tonnage'], 0.001);
        $this->assertEqualsWithDelta(25000.0, $row['nominal'], 0.01);
    }

    public function test_a_missing_physical_count_falls_back_to_the_system_tonnage(): void
    {
        $before = $this->report('2035-03');

        $ritId = $this->rit('TEST-FISIK-MISSING', 1000);
        $this->snapshot('2035-03-20 10:00:00', $ritId, 25, null);

        $after = $this->report('2035-03');

        $this->assertEqualsWithDelta(
            25.0,
            $after['stok_akhir']['total_tonnage'] - $before['stok_akhir']['total_tonnage'],
            0.001
        );

        $row = $this->row($after['stok_akhir']['rows'], $ritId);

        $this->assertSame('sistem', $row['basis']);
        $this->assertNull($row['tonnage_fisik']);
        $this->assertNull($row['selisih']);
        $this->assertNull($row['selisih_nominal']);
        $this->assertEqualsWithDelta(25.0, $row['tonnage'], 0.001);
    }

    public function test_a_zero_physical_count_keeps_the_row_with_no_value(): void
    {
        $ritId = $this->rit('TEST-FISIK-ZERO', 1000);
        $this->snapshot('2035-03-20 10:00:00', $ritId, 3.3, 0);

        $report = $this->report('2035-03');

        $row = $this->row($report['stok_akhir']['rows'], $ritId);

        $this->assertSame('fisik', $row['basis']);
        $this->assertEqualsWithDelta(0.0, $row['tonnage'], 0.001);
        $this->assertEqualsWithDelta(3.3, $row['tonnage_sistem'], 0.001);
        $this->assertEqualsWithDelta(-3.3, $row['selisih'], 0.001);
        $this->assertEqualsWithDelta(0.0, $row['nominal'], 0.01);
    }

    public function test_the_latest_snapshot_on_or_before_the_cutoff_wins(): void
    {
        $ritId = $this->rit('TEST-LATEST', 1000);
        $this->snapshot('2035-03-15 10:00:00', $ritId, 30, 10);
        $this->snapshot('2035-03-20 10:00:00', $ritId, 25, 20);

        $row = $this->row($this->report('2035-03')['stok_akhir']['rows'], $ritId);

        $this->assertEqualsWithDelta(25.0, $row['tonnage_sistem'], 0.001);
        $this->assertEqualsWithDelta(20.0, $row['tonnage'], 0.001);
    }

    public function test_a_snapshot_after_the_cutoff_does_not_leak_into_the_month(): void
    {
        $ritId = $this->rit('TEST-LOOKAHEAD', 1000);
        $this->snapshot('2035-03-20 10:00:00', $ritId, 25, 20);
        $this->snapshot('2035-04-05 10:00:00', $ritId, 25, 5);

        $march = $this->row($this->report('2035-03')['stok_akhir']['rows'], $ritId);
        $april = $this->row($this->report('2035-04')['stok_akhir']['rows'], $ritId);

        $this->assertEqualsWithDelta(20.0, $march['tonnage'], 0.001);
        $this->assertEqualsWithDelta(5.0, $april['tonnage'], 0.001);
    }

    public function test_stock_blocks_expose_system_physical_and_shrinkage_totals(): void
    {
        $before = $this->report('2035-03');

        $short = $this->rit('TEST-TOTAL-SHORT', 1000);
        $surplus = $this->rit('TEST-TOTAL-SURPLUS', 1000);
        $missing = $this->rit('TEST-TOTAL-MISSING', 1000);

        $this->snapshot('2035-03-20 10:00:00', $short, 25, 20);
        $this->snapshot('2035-03-20 10:00:00', $surplus, 10, 12);
        $this->snapshot('2035-03-20 10:00:00', $missing, 5, null);

        $after = $this->report('2035-03');
        $block = $after['stok_akhir'];

        $this->assertEqualsWithDelta(35.0, $block['total_tonnage'] - $before['stok_akhir']['total_tonnage'], 0.001);
        $this->assertEqualsWithDelta(40.0, $block['total_sistem_tonnage'] - $before['stok_akhir']['total_sistem_tonnage'], 0.001);
        $this->assertEqualsWithDelta(32.0, $block['total_fisik_tonnage'] - $before['stok_akhir']['total_fisik_tonnage'], 0.001);
        $this->assertEqualsWithDelta(-3.0, $block['total_selisih_tonnage'] - $before['stok_akhir']['total_selisih_tonnage'], 0.001);
        $this->assertEqualsWithDelta(5.0, $block['penyusutan']['tonnage'] - $before['stok_akhir']['penyusutan']['tonnage'], 0.001);
        $this->assertEqualsWithDelta(5000.0, $block['penyusutan']['nominal'] - $before['stok_akhir']['penyusutan']['nominal'], 0.01);
    }

    public function test_the_month_chain_and_profit_identities_hold_with_physical_stock(): void
    {
        $before = $this->report('2035-03');

        $ritId = $this->rit('TEST-CHAIN', 1000);
        $this->snapshot('2035-03-20 10:00:00', $ritId, 25, 20);

        $march = $this->report('2035-03');
        $april = $this->report('2035-04');

        $this->assertEqualsWithDelta(
            $march['stok_akhir']['total'],
            $april['stok_awal']['total'],
            0.01
        );
        $this->assertEqualsWithDelta(
            $march['stok_awal']['total'] + $march['beli_barang']['total'] - $march['stok_akhir']['total'],
            $march['hpp'],
            0.01
        );
        $this->assertEqualsWithDelta(
            $march['omset'] - $march['biaya'] - $march['hpp'],
            $march['laba'],
            0.01
        );
        $this->assertEqualsWithDelta($before['biaya'], $march['biaya'], 0.01);
    }

    public function test_a_small_negative_selisih_is_still_applied(): void
    {
        $ritId = $this->rit('TEST-SMALL-SELISIH', 1000);
        $this->snapshot('2035-03-20 10:00:00', $ritId, 25, 24.85);

        $row = $this->row($this->report('2035-03')['stok_akhir']['rows'], $ritId);

        $this->assertSame('fisik', $row['basis']);
        $this->assertEqualsWithDelta(24.85, $row['tonnage'], 0.001);
        $this->assertEqualsWithDelta(-0.15, $row['selisih'], 0.001);
    }

    private function report(string $month): array
    {
        return $this->postJson('/api/admin/laba_rugi/get_report', ['month' => $month])
            ->assertOk()
            ->json('data.results');
    }

    private function rit(string $code, float $buyPrice): int
    {
        $itemId = DB::table('items')->insertGetId([
            'code' => $code,
            'brand' => 'TEST',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return DB::table('rits')->insertGetId([
            'do_code' => $code . '-DO',
            'expected_tonnage' => 100,
            'arrived_tonnage' => 100,
            'buy_price' => $buyPrice,
            'arrival_date' => '2035-03-10',
            'item_id' => $itemId,
            'tonnage_left' => 100,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function snapshot(string $date, int $ritId, float $system, ?float $physical): void
    {
        $reportId = DB::table('reports')->insertGetId([
            'created_at' => $date,
            'updated_at' => $date,
        ]);

        DB::table('report_rits')->insert([
            'report_id' => $reportId,
            'rit_id' => $ritId,
            'tonnage_left' => $system,
            'real_tonnage' => $physical,
            'created_at' => $date,
            'updated_at' => $date,
        ]);
    }

    private function row(array $rows, int $ritId): array
    {
        foreach ($rows as $row) {
            if ($row['rit_id'] === $ritId) {
                return $row;
            }
        }

        $this->fail("RIT {$ritId} was not present in the stock rows.");
    }
}
