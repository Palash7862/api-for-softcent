<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class BitcoinApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_bitcoin_info_validation()
    {
        $response = $this->get('/api/getBitcoinInfo');

        $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll('message', 'errors')
        );
        $response->assertStatus(400);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_bitcoin_info_success()
    {
        $response = $this->get('/api/getBitcoinInfo?currency=eur');

        $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll('current_rate', 'min_rate', 'max_rate')
        );
        $response->assertStatus(200);
    }
}
