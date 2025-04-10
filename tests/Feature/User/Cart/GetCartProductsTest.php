<?php

namespace Tests\Feature\User\Cart;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetCartProductsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();

        $this->actingAs($user, 'api');

        $this->post('/api/user/cart/add', [
            'product_id' => 1,
            'quantity' => 5
        ]);
    }

    public function test_get_cart_products_by_user(): void
    {
        $response = $this->get('/api/user/cart');

        $response->assertOk();

        $response->assertJsonPath('result', true);

        $response->assertJsonStructure([
            'result',
            'data' => [
                'cart_id',
                'items' => [
                    '*' => [
                        'id',
                        'category_id',
                        'name',
                        'price',
                        'description',
                        'pivot'
                    ]
                ]
            ]
        ]);
    }
}
