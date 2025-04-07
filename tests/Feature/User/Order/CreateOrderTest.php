<?php

namespace Tests\Feature\User\Order;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateOrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_order_test(): void
    {
        $token = $this->getAuthToken(false);

        $response = $this->post('/api/user/order/create', [
            'address' => 'NewYork, Trump st. 115',
            'phoneNumber' => '+9133782288',
            'deliveryTime' => '01:30'
        ], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertOk();

        $response->assertJsonPath('result', true);
    }
}
