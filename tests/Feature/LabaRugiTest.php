<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

class LabaRugiTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Passport::actingAs(User::first());
    }

    public function test_laba_rugi_report_returns_the_spreadsheet_values(): void
    {
        $response = $this->postJson('/api/admin/laba_rugi/get_report', [
            'month' => '2026-10',
        ]);

        $response->assertOk()->assertJsonPath('data.status', true);

        $results = $response->json('data.results');

        $this->assertSame('2026-10', $results['month']);
        $this->assertArrayHasKey('stok_awal', $results);
        $this->assertArrayHasKey('stok_akhir', $results);
        $this->assertArrayHasKey('beli_barang', $results);

        $expectedHpp = $results['stok_awal']['total']
            + $results['beli_barang']['total']
            - $results['stok_akhir']['total'];

        $this->assertEqualsWithDelta($expectedHpp, $results['hpp'], 0.01);

        $expectedLaba = $results['omset'] - $results['biaya'] - $results['hpp'];

        $this->assertEqualsWithDelta($expectedLaba, $results['laba'], 0.01);
    }

    public function test_stok_akhir_of_a_month_equals_stok_awal_of_the_next(): void
    {
        $september = $this->postJson('/api/admin/laba_rugi/get_report', [
            'month' => '2026-09',
        ])->json('data.results');

        $october = $this->postJson('/api/admin/laba_rugi/get_report', [
            'month' => '2026-10',
        ])->json('data.results');

        $this->assertEqualsWithDelta(
            $september['stok_akhir']['total'],
            $october['stok_awal']['total'],
            0.01
        );
    }

    public function test_invalid_month_is_rejected(): void
    {
        $this->postJson('/api/admin/laba_rugi/get_report', [
            'month' => 'invalid',
        ])->assertStatus(422);
    }
}
