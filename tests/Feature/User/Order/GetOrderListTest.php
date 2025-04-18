<?php

namespace Tests\Feature\User\Order;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetOrderListTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_order_list_by_user(): void
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

        $response = $this->getJson('api/user/order');

        $response->assertOk()->assertJsonPath('result', true);
    }

    public function test_cant_get_order_list_by_unauthenticated()
    {
        $response = $this->getJson('api/user/order');

        $response->assertStatus(401);
    }
}
