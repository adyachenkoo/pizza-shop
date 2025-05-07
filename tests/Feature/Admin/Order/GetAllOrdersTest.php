<?php

namespace Tests\Feature\Admin\Order;

use App\Contracts\OrderMailerInterface;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetAllOrdersTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->mock(OrderMailerInterface::class)
            ->shouldReceive('sendOrderCreated')
            ->once();

        $user = User::factory()->admin()->create();

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
    }

    public function test_get_all_orders_by_admin(): void
    {
        $response = $this->getJson('api/admin/order');

        $response->assertOk()->assertJsonPath('result', true);
    }
}
