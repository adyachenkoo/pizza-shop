<?php

namespace Tests\Feature\User\Order;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetOrderHistoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_order_history_by_user(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'api');

        $this->postJson('/api/user/cart/add', [
            'product_id' => 1,
            'quantity' => 5
        ]);

        $this->postJson('/api/user/order/create', [
            'address' => 'NewYork, Trump st. 115',
            'phoneNumber' => '+9133782288',
            'deliveryTime' => '01:30'
        ]);

        $token = $this->getAuthToken(true);

        $this->postJson('/api/admin/order/update', [
            'order_id' => 1,
            'status_id' => 1,
        ], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response = $this->getJson('api/user/order/history');

        $response->assertOk()->assertJsonPath('result', true);
    }

    public function test_cant_get_order_history_by_unauthenticated()
    {
        $response = $this->getJson('api/user/order/history');

        $response->assertStatus(401);
    }
}
