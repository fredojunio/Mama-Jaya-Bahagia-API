<?php

namespace Tests\Feature;

use App\Models\Coa;
use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

class CoaTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Passport::actingAs(User::first());
    }

    public function test_coa_index_returns_leaf_accounts_only(): void
    {
        $response = $this->getJson('/api/admin/coa?leaves_only=1');

        $response->assertOk()->assertJsonPath('data.status', true);

        $results = $response->json('data.results');

        $this->assertNotEmpty($results);

        foreach ($results as $coa) {
            $this->assertFalse($coa['is_parent']);
        }
    }

    public function test_expense_filter_by_coa_id_returns_only_that_coa(): void
    {
        $coa = Coa::where('code', '4.2.00.09')->firstOrFail();

        $response = $this->postJson('/api/admin/expense/filter', [
            'start_date' => 'Mon Jan 01 2024 00:00:00 GMT+0700',
            'end_date' => 'Fri Dec 31 2027 23:59:59 GMT+0700',
            'coa_id' => $coa->id,
        ]);

        $response->assertOk()->assertJsonPath('data.status', true);

        foreach ($response->json('data.results') as $expense) {
            $this->assertSame($coa->id, $expense['coa_id']);
        }
    }
}
