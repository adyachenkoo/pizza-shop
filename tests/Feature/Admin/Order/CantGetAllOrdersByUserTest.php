<?php

namespace Tests\Feature\Admin\Order;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CantGetAllOrdersByUserTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();

        $this->actingAs($user, 'api');
    }
    public function test_user_cannot_get_all_orders()
    {
        $response = $this->getJson('/api/admin/order');

        $response->assertOk()->assertJsonPath('result', false);
    }
}
