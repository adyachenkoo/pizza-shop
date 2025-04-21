<?php

namespace Tests\Feature\Admin\Order;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChangeOrderStatusTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

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

    public function test_change_order_status_by_admin(): void
    {
        $response = $this->postJson('/api/admin/order/update', [
            'order_id' => 1,
            'status_id' => 2,
        ]);

        $response->assertOk()->assertJsonPath('result', true);

        $this->assertDatabaseHas('orders', [
            'id' => 1,
            'status_id' => 2,
        ]);
    }

    public function test_user_cannot_change_order_status()
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'api');

        $response = $this->postJson('/api/admin/order/update', [
            'order_id' => 1,
            'status_id' => 2,
        ]);

        $response->assertOk()->assertJsonPath('result', false);
    }
}
