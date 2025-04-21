<?php

namespace Tests\Feature\User\Cart;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddProductToCartTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();

        $this->actingAs($user, 'api');
    }

    public function test_add_product_to_cart_by_user(): void
    {
        $response = $this->postJson('/api/user/cart/add', [
            'product_id' => 1,
            'quantity' => 5
        ]);

        $response->assertOk()->assertJsonPath('result', true);

        $this->assertDatabaseHas('cart_product', [
            'product_id' => 1,
            'quantity' => 5
        ]);
    }

    public function test_cant_add_product_to_cart_without_data()
    {
        $response = $this->postJson('/api/user/cart/add');

        $response->assertStatus(422);
    }
}
