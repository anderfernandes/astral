<?php

namespace Tests\Feature;

use Illuminate\Support\Carbon;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ReportTest extends TestCase
{
    /**
     * Authenticate before interacting with app.
     */
    protected function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs($this->user);
    }

    /**
     * A basic feature test example.
     */
    public function test_closeout_report(): void
    {
        $user = $this->user;

        $start = Carbon::now()->startOfDay()->subDays(7)->timestamp;
        $end = Carbon::now()->startOfDay()->subdays(1)->timestamp;

        $response = $this->get("/api/reports/closeout?cashier=$user->id&start=$start&end=$end");

        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     */
    public function test_payment_report(): void
    {
        $user = $this->user;

        $start = Carbon::now()->startOfDay()->subDays(7)->timestamp;
        $end = Carbon::now()->startOfDay()->subdays(1)->timestamp;

        $response = $this->get("/api/reports/payment?cashier=$user->id&start=$start&end=$end");

        $response->assertStatus(200);
    }
}
