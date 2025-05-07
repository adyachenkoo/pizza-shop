<?php

namespace Tests\Feature\User\Order;

use App\Contracts\OrderMailerInterface;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetOrderHistoryTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->mock(OrderMailerInterface::class)
            ->shouldReceive('sendOrderCreated')
            ->once();

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

        $this->postJson('/api/admin/order/update', [
            'order_id' => 1,
            'status_id' => 1,
        ]);
    }

    public function test_get_order_history_by_user(): void
    {
        $response = $this->getJson('api/user/order/history');

        $response->assertOk()->assertJsonPath('result', true);
    }
}
