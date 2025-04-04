<?php

namespace Tests\Feature\User\Cart;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddProductToCartTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_product_to_cart(): void
    {
        $token = $this->getAuthToken();

        $response = $this->post('/api/user/cart/add', [
            'product_id' => 1,
            'quantity' => 5
        ], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertOk();

        $response->assertJsonPath('result', true);
    }
}
