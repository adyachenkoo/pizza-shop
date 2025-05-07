<?php

namespace Tests\Feature\User\Order;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CantGetOrderHistoryByGuestTest extends TestCase
{
    public function test_cant_get_order_history_by_guest()
    {
        $response = $this->getJson('api/user/order/history');

        $response->assertStatus(401);
    }
}
