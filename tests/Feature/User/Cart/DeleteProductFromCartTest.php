<?php

namespace Tests\Feature\User\Cart;

use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteProductFromCartTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();

        $this->actingAs($user, 'api');

        $this->postJson('/api/user/cart/add', [
            'product_id' => 3,
            'quantity' => 5
        ]);
    }

    public function test_delete_product_from_cart_by_user(): void
    {
        $response = $this->deleteJson('/api/user/cart/delete', [
            'product_id' => 3,
        ]);

        $response->assertOk()->assertJsonPath('result', true);
    }

    public function test_cant_delete_product_without_data()
    {
        $response = $this->deleteJson('/api/user/cart/delete');

        $response->assertStatus(422);
    }
}
