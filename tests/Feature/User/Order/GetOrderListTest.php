<?php

namespace Tests\Feature\User\Order;

use App\Contracts\OrderMailerInterface;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class GetOrderListTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Bus::fake();

        $user = User::factory()->create();

        $this->actingAs($user, 'api');

        $this->postJson('/api/user/cart/add', [
            'product_id' => 1,
            'quantity' => 5
        ]);

        $this->postJson('/api/user/order/create', [
            'address' => 'NewYork, Trump st. 115',
            'phoneNumber' => '+79133782288',
            'deliveryTime' => '01:30'
        ]);
    }

    public function test_get_order_list_by_user(): void
    {
        $response = $this->getJson('api/user/order');

        $response->assertOk()->assertJsonPath('result', true);
    }
}
