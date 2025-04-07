<?php

namespace Tests\Feature\User\Cart;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteProductFromCartTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_product_from_cart(): void
    {
        $token = $this->getAuthToken(false);

        $response = $this->delete('/api/user/cart/delete', [
            'product_id' => 3,
        ], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertOk();

        $response->assertJsonPath('result', true);
    }
}
