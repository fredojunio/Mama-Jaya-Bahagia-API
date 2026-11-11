<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Passport;
use Tests\TestCase;

class LabaRugiTonnageTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        Passport::actingAs(User::first());
    }

    public function test_report_exposes_tonnage_for_stock_purchases_and_sales(): void
    {
        $before = $this->report('2035-03');

        $itemId = DB::table('items')->insertGetId([
            'code' => 'TEST-TON',
            'brand' => 'TEST',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $ritId = DB::table('rits')->insertGetId([
            'do_code' => 'TEST-DO-1',
            'expected_tonnage' => 100,
            'arrived_tonnage' => 100,
            'buy_price' => 1000,
            'arrival_date' => '2035-03-10',
            'item_id' => $itemId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $openingReportId = DB::table('reports')->insertGetId([
            'created_at' => '2035-02-28 23:59:59',
            'updated_at' => '2035-02-28 23:59:59',
        ]);

        $closingReportId = DB::table('reports')->insertGetId([
            'created_at' => '2035-03-20 10:00:00',
            'updated_at' => '2035-03-20 10:00:00',
        ]);

        DB::table('report_rits')->insert([
            [
                'report_id' => $openingReportId,
                'rit_id' => $ritId,
                'tonnage_left' => 40,
                'created_at' => '2035-02-28 23:59:59',
                'updated_at' => '2035-02-28 23:59:59',
            ],
            [
                'report_id' => $closingReportId,
                'rit_id' => $ritId,
                'tonnage_left' => 25,
                'created_at' => '2035-03-20 10:00:00',
                'updated_at' => '2035-03-20 10:00:00',
            ],
        ]);

        DB::table('rit_transactions')->insert([
            [
                'daily_id' => 1,
                'customer_name' => 'TEST',
                'tonnage' => 10,
                'item_price' => 5000,
                'total_price' => 45000,
                'rit_id' => $ritId,
                'created_at' => '2035-03-05 10:00:00',
                'updated_at' => '2035-03-05 10:00:00',
            ],
            [
                'daily_id' => 2,
                'customer_name' => 'TEST',
                'tonnage' => 15,
                'item_price' => 5000,
                'total_price' => 75000,
                'rit_id' => $ritId,
                'created_at' => '2035-03-15 10:00:00',
                'updated_at' => '2035-03-15 10:00:00',
            ],
            [
                'daily_id' => 3,
                'customer_name' => 'TEST',
                'tonnage' => 99,
                'item_price' => 5000,
                'total_price' => 495000,
                'rit_id' => $ritId,
                'created_at' => '2035-02-15 10:00:00',
                'updated_at' => '2035-02-15 10:00:00',
            ],
        ]);

        $after = $this->report('2035-03');

        $this->assertEqualsWithDelta(40.0, $after['stok_awal']['total_tonnage'] - $before['stok_awal']['total_tonnage'], 0.001);
        $this->assertEqualsWithDelta(100.0, $after['beli_barang']['total_tonnage'] - $before['beli_barang']['total_tonnage'], 0.001);
        $this->assertEqualsWithDelta(25.0, $after['stok_akhir']['total_tonnage'] - $before['stok_akhir']['total_tonnage'], 0.001);
        $this->assertEqualsWithDelta(25.0, $after['omset_tonnage'] - $before['omset_tonnage'], 0.001);
    }

    private function report(string $month): array
    {
        return $this->postJson('/api/admin/laba_rugi/get_report', ['month' => $month])
            ->assertOk()
            ->json('data.results');
    }
}
