<?php

namespace Tests\Feature\User\Cart;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetCartProductsTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_cart_products(): void
    {
        $token = $this->getAuthToken(false);

        $this->post('/api/user/cart/add', [
            'product_id' => 1,
            'quantity' => 5
        ], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response = $this->get('/api/user/cart', [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertOk();

        $response->assertJsonPath('result', true);

        $response->assertJsonStructure([
            'result',
            'data' => [
                '*' => [
                    'id',
                    'user_id',
                    'product_id',
                    'quantity',
                    'category_id',
                ]
            ]
        ]);
    }
}
