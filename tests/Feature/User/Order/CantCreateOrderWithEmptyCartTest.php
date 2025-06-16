<?php

namespace Tests\Feature\User\Order;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CantCreateOrderWithEmptyCartTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();

        $this->actingAs($user, 'api');
    }

    public function test_cant_create_order_with_empty_cart(): void
    {
        $response = $this->postJson('/api/user/order/create', [
            'address' => 'NewYork, Trump st. 115',
            'phoneNumber' => '+79133782288',
            'deliveryTime' => '01:30'
        ]);

        $response->assertOk()->assertJsonPath('result', false);
    }
}
