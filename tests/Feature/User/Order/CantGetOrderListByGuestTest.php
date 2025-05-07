<?php

namespace Tests\Feature\User\Order;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CantGetOrderListByGuestTest extends TestCase
{
    public function test_cant_get_order_list_by_guest()
    {
        $response = $this->getJson('api/user/order');

        $response->assertStatus(401);
    }
}
