<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Passport;
use Tests\TestCase;

class RitBuyPriceTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        Passport::actingAs(User::first());
    }

    public function test_arrival_requires_buy_price(): void
    {
        $rit = $this->makeRit();

        $this->postJson("/api/admin/rit/{$rit->id}/arrived", $this->arrivalPayload())
            ->assertStatus(422);

        $this->assertNull(DB::table('rits')->where('id', $rit->id)->value('arrival_date'));
        $this->assertNull(DB::table('rits')->where('id', $rit->id)->value('tonnage_left'));
        $this->assertNull(DB::table('rits')->where('id', $rit->id)->value('arrived_tonnage'));
    }

    public function test_arrival_rejects_zero_buy_price(): void
    {
        $rit = $this->makeRit();

        $this->postJson("/api/admin/rit/{$rit->id}/arrived", $this->arrivalPayload([
            'buy_price' => 0,
        ]))->assertStatus(422);
    }

    public function test_arrival_stores_buy_price(): void
    {
        $rit = $this->makeRit();

        $this->postJson("/api/admin/rit/{$rit->id}/arrived", $this->arrivalPayload([
            'buy_price' => 1250,
        ]))->assertOk();

        $stored = DB::table('rits')->where('id', $rit->id)->first();

        $this->assertEqualsWithDelta(1250, $stored->buy_price, 0.001);
        $this->assertNotNull($stored->arrival_date);
        $this->assertEqualsWithDelta(100, $stored->tonnage_left, 0.001);
    }

    public function test_pricing_rejects_missing_buy_price(): void
    {
        $rit = $this->makeRit();

        $this->postJson("/api/admin/rit/{$rit->id}/priced", [
            'tonnage' => 100,
            'sell_price' => 1500,
            'is_hold' => false,
        ])->assertStatus(422);

        $this->assertNull(DB::table('rits')->where('id', $rit->id)->value('buy_price'));
    }

    public function test_pricing_rejects_zero_buy_price(): void
    {
        $rit = $this->makeRit([
            'buy_price' => 1000,
            'sell_price' => 1200,
        ]);

        $this->postJson("/api/admin/rit/{$rit->id}/priced", [
            'tonnage' => 100,
            'sell_price' => 1500,
            'buy_price' => 0,
            'is_hold' => false,
        ])->assertStatus(422);

        $stored = DB::table('rits')->where('id', $rit->id)->first();

        $this->assertEqualsWithDelta(1000, $stored->buy_price, 0.001);
        $this->assertEqualsWithDelta(1200, $stored->sell_price, 0.001);
    }

    public function test_sale_is_rejected_when_a_rit_has_no_buy_price(): void
    {
        $customerId = $this->makeCustomer();
        $rit = $this->makeRit([
            'arrival_date' => now()->toDateString(),
            'arrived_tonnage' => 100,
            'tonnage_left' => 100,
            'sell_price' => 1500,
            'is_hold' => 0,
        ]);

        $response = $this->postJson(
            '/api/admin/transaction',
            $this->salePayload($customerId, $rit)
        );

        $response->assertStatus(422);
        $this->assertStringContainsString($rit->item_code, $response->json('message'));

        $this->assertSame(0, DB::table('transactions')->where('customer_id', $customerId)->count());
        $this->assertSame(0, DB::table('rit_transactions')->where('rit_id', $rit->id)->count());
        $this->assertSame(0, DB::table('rit_histories')->where('rit_id', $rit->id)->count());
        $this->assertEqualsWithDelta(
            100,
            DB::table('rits')->where('id', $rit->id)->value('tonnage_left'),
            0.001
        );
    }

    public function test_sale_is_rejected_when_a_rit_has_zero_buy_price(): void
    {
        $customerId = $this->makeCustomer();
        $rit = $this->makeRit([
            'arrival_date' => now()->toDateString(),
            'arrived_tonnage' => 100,
            'tonnage_left' => 100,
            'sell_price' => 1500,
            'buy_price' => 0,
            'is_hold' => 0,
        ]);

        $this->postJson(
            '/api/admin/transaction',
            $this->salePayload($customerId, $rit)
        )->assertStatus(422);

        $this->assertSame(0, DB::table('rit_transactions')->where('rit_id', $rit->id)->count());
    }

    public function test_revision_is_rejected_when_a_rit_has_no_buy_price(): void
    {
        $customerId = $this->makeCustomer();
        $rit = $this->makeRit([
            'arrival_date' => now()->toDateString(),
            'arrived_tonnage' => 100,
            'tonnage_left' => 100,
            'sell_price' => 1500,
            'is_hold' => 0,
        ]);

        $transactionId = DB::table('transactions')->insertGetId([
            'daily_id' => 999999,
            'type' => 'Biasa',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->patchJson("/api/admin/transaction/{$transactionId}", [
            'new_transaction' => $this->salePayload($customerId, $rit),
        ])->assertStatus(422);

        $this->assertSame(0, DB::table('rit_transactions')->where('rit_id', $rit->id)->count());
        $this->assertEqualsWithDelta(
            100,
            DB::table('rits')->where('id', $rit->id)->value('tonnage_left'),
            0.001
        );
    }

    public function test_sale_succeeds_for_a_rit_with_buy_price(): void
    {
        $customerId = $this->makeCustomer();
        $rit = $this->makeRit([
            'arrival_date' => now()->toDateString(),
            'arrived_tonnage' => 100,
            'tonnage_left' => 100,
            'sell_price' => 1500,
            'buy_price' => 1000,
            'is_hold' => 0,
        ]);

        $this->postJson(
            '/api/admin/transaction',
            $this->salePayload($customerId, $rit)
        )->assertOk();

        $this->assertSame(1, DB::table('rit_transactions')->where('rit_id', $rit->id)->count());
        $this->assertEqualsWithDelta(
            99,
            DB::table('rits')->where('id', $rit->id)->value('tonnage_left'),
            0.001
        );
    }

    public function test_stock_listing_still_includes_rits_without_buy_price(): void
    {
        $rit = $this->makeRit([
            'arrival_date' => now()->toDateString(),
            'arrived_tonnage' => 100,
            'tonnage_left' => 100,
            'sell_price' => 1500,
            'is_hold' => 0,
        ]);

        $response = $this->getJson('/api/admin/rit/get_all_stock')->assertOk();

        $ids = collect($response->json('data.results'))->pluck('id');

        $this->assertTrue($ids->contains($rit->id));
    }

    private function salePayload(int $customerId, object $rit): array
    {
        return [
            'customer_id' => $customerId,
            'date' => now()->toDateString(),
            'tb' => 0,
            'tw' => 0,
            'thr' => 0,
            'sack' => 0,
            'sack_free' => 0,
            'other' => 0,
            'discount' => 0,
            'ongkir' => 0,
            'item_prices' => 1500,
            'total_price' => 1500,
            'rits' => [
                [
                    'item' => ['id' => $rit->id],
                    'tonnage' => 1,
                    'masak' => 1,
                    'price' => 1500,
                    'total_price' => 1500,
                    'real_tonnage' => 1,
                ],
            ],
        ];
    }

    private function makeCustomer(): int
    {
        return DB::table('customers')->insertGetId([
            'nik' => 'TEST-' . uniqid(),
            'name' => 'TEST CUSTOMER',
            'nickname' => 'TEST',
            'address' => 'TEST',
            'birthdate' => '2000-01-01',
            'type' => 'Biasa',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function arrivalPayload(array $overrides = []): array
    {
        return array_merge([
            'tonnage' => 100,
            'sack' => 10,
            'toll_used' => 0,
            'bbm_used' => 0,
        ], $overrides);
    }

    private function makeRit(array $overrides = []): object
    {
        $code = 'TEST-BP-' . uniqid();

        $itemId = DB::table('items')->insertGetId([
            'code' => $code,
            'brand' => 'TEST',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $vehicleId = DB::table('vehicles')->insertGetId([
            'name' => 'TEST-VEHICLE',
            'type' => 'Truk',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $tripId = DB::table('trips')->insertGetId([
            'vehicle_id' => $vehicleId,
            'allowance' => 0,
            'toll' => 0,
            'gas' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $id = DB::table('rits')->insertGetId(array_merge([
            'do_code' => $code,
            'expected_tonnage' => 100,
            'main_tonnage' => 100,
            'item_id' => $itemId,
            'trip_id' => $tripId,
            'created_at' => now(),
            'updated_at' => now(),
        ], $overrides));

        return (object) [
            'id' => $id,
            'item_id' => $itemId,
            'item_code' => $code,
        ];
    }
}
