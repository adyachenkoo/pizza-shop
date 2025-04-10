<?php

namespace Tests\Feature\Admin\Product;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteProductTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->admin()->create();

        $this->actingAs($user, 'api');
    }

    public function test_delete_product_by_admin(): void
    {
        $response = $this->delete('/api/admin/product/delete', [
            'product_id' => 5
        ]);

        $response->assertOk()->assertJsonPath('result', true);
    }

    public function test_cant_delete_product_without_data()
    {
        $response = $this->deleteJson('/api/admin/product/delete');

        $response->assertStatus(422);
    }
}
