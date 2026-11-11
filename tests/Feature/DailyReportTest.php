<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Passport;
use Tests\TestCase;

class DailyReportTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        Passport::actingAs(User::first());
    }

    public function test_physical_counts_are_saved_against_their_own_rit_regardless_of_order(): void
    {
        $this->rit('TEST-SAVE-A');
        $this->rit('TEST-SAVE-B');

        $preview = $this->previewRows();
        $a = $this->previewRitByCode($preview, 'TEST-SAVE-A');
        $b = $this->previewRitByCode($preview, 'TEST-SAVE-B');

        $payload = $this->payloadFrom($preview, [
            $a['rit_id'] => 70,
            $b['rit_id'] => 40,
        ]);
        $payload = array_reverse($payload);

        $response = $this->postJson('/api/admin/report/create_daily_report', [
            'rits' => $payload,
            'real_income' => 0,
        ])->assertOk();

        $saved = collect($response->json('data.results.rits'))->keyBy('rit.item.code');

        $this->assertEqualsWithDelta(70.0, $saved['TEST-SAVE-A']['real_tonnage'], 0.001);
        $this->assertEqualsWithDelta(40.0, $saved['TEST-SAVE-B']['real_tonnage'], 0.001);

        $readBack = collect(
            $this->getJson('/api/admin/report/' . $response->json('data.results.id'))
                ->assertOk()
                ->json('data.results.rits')
        )->keyBy('rit.item.code');

        $this->assertEqualsWithDelta(70.0, $readBack['TEST-SAVE-A']['real_tonnage'], 0.001);
        $this->assertEqualsWithDelta(40.0, $readBack['TEST-SAVE-B']['real_tonnage'], 0.001);
    }

    public function test_a_missing_physical_count_is_rejected_without_writing_anything(): void
    {
        $this->rit('TEST-MISSING-COUNT');

        $payload = $this->payloadFrom($this->previewRows(), []);
        array_pop($payload);

        $before = $this->counts();

        $this->postJson('/api/admin/report/create_daily_report', [
            'rits' => $payload,
            'real_income' => 0,
        ])->assertStatus(422);

        $this->assertSame($before, $this->counts());
    }

    public function test_an_unknown_rit_is_rejected(): void
    {
        $payload = $this->payloadFrom($this->previewRows(), []);
        $payload[] = ['rit_id' => 999999999, 'real_tonnage' => 1];

        $before = $this->counts();

        $this->postJson('/api/admin/report/create_daily_report', [
            'rits' => $payload,
            'real_income' => 0,
        ])->assertStatus(422);

        $this->assertSame($before, $this->counts());
    }

    public function test_a_duplicate_rit_is_rejected(): void
    {
        $payload = $this->payloadFrom($this->previewRows(), []);
        $payload[] = $payload[0];

        $before = $this->counts();

        $this->postJson('/api/admin/report/create_daily_report', [
            'rits' => $payload,
            'real_income' => 0,
        ])->assertStatus(422);

        $this->assertSame($before, $this->counts());
    }

    public function test_a_negative_physical_count_is_rejected(): void
    {
        $payload = $this->payloadFrom($this->previewRows(), []);
        $payload[0]['real_tonnage'] = -1;

        $before = $this->counts();

        $this->postJson('/api/admin/report/create_daily_report', [
            'rits' => $payload,
            'real_income' => 0,
        ])->assertStatus(422);

        $this->assertSame($before, $this->counts());
    }

    public function test_a_rejected_save_keeps_the_existing_daily_report(): void
    {
        $payload = $this->payloadFrom($this->previewRows(), []);

        $reportId = $this->postJson('/api/admin/report/create_daily_report', [
            'rits' => $payload,
            'real_income' => 0,
        ])->assertOk()->json('data.results.id');

        $payload[0]['real_tonnage'] = -1;

        $this->postJson('/api/admin/report/create_daily_report', [
            'rits' => $payload,
            'real_income' => 0,
        ])->assertStatus(422);

        $this->getJson('/api/admin/report/' . $reportId)->assertOk();
    }

    private function counts(): array
    {
        return [
            'reports' => DB::table('reports')->count(),
            'report_rits' => DB::table('report_rits')->count(),
        ];
    }

    private function previewRows(): array
    {
        return $this->getJson('/api/admin/report/get_today_report')
            ->assertOk()
            ->json('data.results')[1];
    }

    private function previewRitByCode(array $preview, string $code): array
    {
        foreach ($preview as $row) {
            if (($row['rit']['item']['code'] ?? null) === $code) {
                return $row;
            }
        }

        $this->fail("RIT {$code} was not present in the daily report preview.");
    }

    private function payloadFrom(array $preview, array $overrides): array
    {
        $payload = [];

        foreach ($preview as $row) {
            $ritId = $row['rit_id'];

            $payload[] = [
                'rit_id' => $ritId,
                'real_tonnage' => $overrides[$ritId] ?? (float) $row['tonnage_left'],
            ];
        }

        return $payload;
    }

    private function rit(string $code): int
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
            'buy_price' => 1000,
            'arrival_date' => now(),
            'item_id' => $itemId,
            'tonnage_left' => 100,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
